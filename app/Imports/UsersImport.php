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
use Maatwebsite\Excel\Concerns\WithUpserts;

class UsersImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows, WithUpserts
{
    public function model(array $row): ?Model
    {
        // توقّع ترتيب الأعمدة:
        // [0] barcode/id, [1] category_name, [2] name_ar, [3] name_en, [4] unit_name

        $barcode   = isset($row[0]) ? trim((string)$row[0]) : null;
        $catName   = isset($row[1]) ? trim((string)$row[1]) : '';
        $nameAr    = isset($row[2]) ? trim((string)$row[2]) : '';
        $nameEn    = isset($row[3]) ? trim((string)$row[3]) : '';
        $unitName  = isset($row[4]) ? trim((string)$row[4]) : '';

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
