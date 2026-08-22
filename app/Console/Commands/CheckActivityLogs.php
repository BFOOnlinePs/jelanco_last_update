<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckActivityLogs extends Command
{
    protected $signature = 'activity:check';

    protected $description = 'فحص جداول سجل النشاطات (الطلبيات والمنتجات) والتأكد من وجود الأعمدة والبيانات';

    /**
     * الأعمدة المطلوبة لكل جدول سجل.
     */
    private array $tables = [
        'order_activity_logs' => [
            'key'     => 'order_id',
            'columns' => ['id', 'order_id', 'user_id', 'action', 'description', 'old_value', 'new_value', 'created_at', 'updated_at'],
        ],
        'product_activity_logs' => [
            'key'     => 'product_id',
            'columns' => ['id', 'product_id', 'user_id', 'action', 'description', 'field', 'old_value', 'new_value', 'created_at', 'updated_at'],
        ],
    ];

    public function handle(): int
    {
        $problems = 0;

        foreach ($this->tables as $table => $meta) {
            $this->line('');
            $this->info("== {$table} ==");

            if (! Schema::hasTable($table)) {
                $this->error('  الجدول غير موجود في قاعدة البيانات. شغّل: php artisan migrate');
                $problems++;
                continue;
            }

            $missing = array_values(array_filter(
                $meta['columns'],
                fn ($column) => ! Schema::hasColumn($table, $column)
            ));

            if ($missing) {
                $this->error('  أعمدة ناقصة: ' . implode(', ', $missing));
                $this->line('     => كل عملية تسجيل تفشل بسببها. شغّل: php artisan migrate');
                $problems++;
            } else {
                $this->line('  كل الأعمدة موجودة.');
            }

            $total = DB::table($table)->count();
            $this->line("  عدد السجلات: {$total}");

            if ($total === 0) {
                $this->warn('  الجدول فارغ - لم تُسجَّل أي حركة حتى الآن.');
                $problems++;
                continue;
            }

            $orphans = DB::table($table)->whereNull($meta['key'])->orWhere($meta['key'], 0)->count();
            if ($orphans > 0) {
                $this->error("  {$orphans} سجل بدون {$meta['key']} صحيح (لن تظهر في أي شاشة).");
                $problems++;
            }

            $last = DB::table($table)->orderByDesc('id')->first();
            $this->line('  آخر حركة: ' . ($last->action ?? '-') . ' بتاريخ ' . ($last->created_at ?? '-'));

            $this->line('  أكثر الأنشطة تكراراً:');
            DB::table($table)
                ->select('action', DB::raw('count(*) as total'))
                ->groupBy('action')
                ->orderByDesc('total')
                ->limit(5)
                ->get()
                ->each(fn ($row) => $this->line("    - {$row->action}: {$row->total}"));
        }

        $this->line('');
        if ($problems === 0) {
            $this->info('لا توجد مشاكل في جداول سجل النشاطات.');
            return self::SUCCESS;
        }

        $this->warn("تم رصد {$problems} مشكلة. راجع الرسائل بالأعلى و storage/logs/laravel.log.");
        return self::FAILURE;
    }
}
