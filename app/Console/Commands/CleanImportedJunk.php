<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * ينظّف الوحدات والتصنيفات التي أُنشئت بالخطأ من ملفات Excel، حيث كانت
 * الصيغ غير المحسوبة (=IFERROR(_xlfn.XLOOKUP(...))) تُخزَّن كأسماء وحدات.
 */
class CleanImportedJunk extends Command
{
    protected $signature = 'products:clean-junk {--force : تنفيذ الحذف فعلياً بدل العرض فقط}';

    protected $description = 'حذف الوحدات والتصنيفات التي أُنشئت من صيغ Excel غير المحسوبة';

    /**
     * أكواد أخطاء Excel التي قد تكون خُزّنت كاسم.
     */
    private const EXCEL_ERRORS = [
        '#N/A', '#REF!', '#VALUE!', '#NAME?', '#DIV/0!', '#NULL!', '#NUM!',
        '#SPILL!', '#CALC!', '#GETTING_DATA', '#Not Yet Implemented',
    ];

    public function handle(): int
    {
        $force = (bool) $this->option('force');

        if (! $force) {
            $this->warn('وضع العرض فقط - لن يُحذف شيء. أضف --force للتنفيذ.');
        }

        $this->cleanTable('units', 'unit_name', [
            ['table' => 'product', 'column' => 'unit_id'],
            ['table' => 'order_items', 'column' => 'unit_id'],
        ], $force);

        $this->cleanTable('category_product', 'cat_name', [
            ['table' => 'product', 'column' => 'category_id'],
        ], $force);

        return self::SUCCESS;
    }

    /**
     * @param array<int,array{table:string,column:string}> $references
     */
    private function cleanTable(string $table, string $nameColumn, array $references, bool $force): void
    {
        $this->line('');
        $this->info("== {$table} ==");

        if (! Schema::hasTable($table)) {
            $this->error('  الجدول غير موجود.');
            return;
        }

        $junk = DB::table($table)
            ->where(function ($query) use ($nameColumn) {
                $query->where($nameColumn, 'like', '=%')
                    ->orWhereIn($nameColumn, self::EXCEL_ERRORS);
            })
            ->get(['id', $nameColumn]);

        $total = DB::table($table)->count();
        $this->line("  الإجمالي: {$total} | المشبوهة: " . $junk->count());

        if ($junk->isEmpty()) {
            $this->line('  لا يوجد ما يُحذف.');
            return;
        }

        foreach ($junk->take(5) as $row) {
            $this->line('    - #' . $row->id . ' ' . mb_substr($row->{$nameColumn}, 0, 60) . '...');
        }
        if ($junk->count() > 5) {
            $this->line('    ... و ' . ($junk->count() - 5) . ' غيرها');
        }

        $ids = $junk->pluck('id')->all();

        // نفرّغ الارتباطات أولاً حتى لا تبقى صفوف تشير إلى سجل محذوف.
        foreach ($references as $reference) {
            if (! Schema::hasTable($reference['table'])) {
                continue;
            }

            $linked = DB::table($reference['table'])->whereIn($reference['column'], $ids)->count();
            $this->line("  {$reference['table']}.{$reference['column']} مرتبط بها: {$linked}");

            if ($linked > 0 && $force) {
                DB::table($reference['table'])->whereIn($reference['column'], $ids)->update([$reference['column'] => null]);
            }
        }

        if (! $force) {
            $this->warn('  (لم يُنفَّذ الحذف - أضف --force)');
            return;
        }

        $deleted = DB::table($table)->whereIn('id', $ids)->delete();
        $this->info("  تم حذف {$deleted} سجل.");
    }
}
