<?php

namespace App\Imports;

use App\Models\CategoryProductModel;
use App\Models\ProductModel;
use App\Models\UnitsModel;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithUpserts;

class UsersImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows, WithUpserts, WithCalculatedFormulas
{
    /**
     * أكواد أخطاء Excel التي قد تصل كنص بدل القيمة.
     */
    private const EXCEL_ERRORS = [
        '#N/A', '#REF!', '#VALUE!', '#NAME?', '#DIV/0!', '#NULL!', '#NUM!',
        '#SPILL!', '#CALC!', '#GETTING_DATA', '#Not Yet Implemented',
    ];

    public function model(array $row): ?Model
    {
        // توقّع ترتيب الأعمدة:
        // [0] barcode/id, [1] category_name, [2] name_ar, [3] name_en, [4] unit_name

        $barcode   = $this->cleanValue($row[0] ?? null) ?: null;
        $catName   = $this->cleanValue($row[1] ?? null);
        $nameAr    = $this->cleanValue($row[2] ?? null);
        $nameEn    = $this->cleanValue($row[3] ?? null);
        $unitName  = $this->cleanValue($row[4] ?? null);

        // تجاهل الصفوف الفارغة
        if (!$barcode && !$nameAr && !$nameEn) {
            return null;
        }

        $cat = $catName !== ''
            ? CategoryProductModel::firstOrCreate(['cat_name' => $catName])
            : null;

        $unit = $unitName !== ''
            ? UnitsModel::firstOrCreate(['unit_name' => $unitName])
            : null;

        // ملاحظة: إذا عندك عمود أساسي اسمه id (auto increment)، لا تمرّر product_id
        return new ProductModel([
            // 'product_id' => $barcode, // اشطبها إذا الحقل Auto Increment
            'barcode'          => $barcode,
            'product_name_ar'  => $nameAr,
            'product_name_en'  => $nameEn,
            'category_id'      => $cat?->id,
            'unit_id'          => $unit?->id,
            'product_status'   => 1,
        ]);
    }

    /**
     * تنظيف قيمة الخلية قبل استخدامها.
     *
     * إذا لم يستطع PhpSpreadsheet حساب صيغة (مثل XLOOKUP بمرجع لملف خارجي)
     * تصل الخلية كنص الصيغة نفسها أو ككود خطأ. تخزين هذا النص يعني إنشاء
     * وحدة أو تصنيف باسم الصيغة، لذلك نتجاهله ونتركه فارغاً.
     */
    private function cleanValue($value): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return '';
        }

        if (str_starts_with($value, '=') || in_array($value, self::EXCEL_ERRORS, true)) {
            return '';
        }

        return $value;
    }

    // تخطّي صف العناوين (لو ما عندك عناوين، ارجع 1)
    public function startRow(): int
    {
        return 1;
    }

    // upsert حسب الباركود (عدله إذا بدك حقل تمييز آخر)
    public function uniqueBy()
    {
        return 'barcode';
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
