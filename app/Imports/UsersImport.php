<?php

namespace App\Imports;

use App\Models\CategoryProductModel;
use App\Models\ProductModel;
use App\Models\UnitsModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel,WithStartRow
{
    /**
     * @param array $row
//     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $cat = CategoryProductModel::where('cat_name', $row[1])->first();
        $unit = UnitsModel::where('unit_name', $row[2])->first();
        if (empty($cat)){
            $cat = new CategoryProductModel();
            $cat->cat_name = $row[1];
            $cat->save();
        }
        if (empty($unit)){
            $unit = new UnitsModel();
            $unit->unit_name = $row[2];
            $unit->save();
        }
        return new ProductModel([
            'product_id' => $row[0],
            'product_name_ar' => $row[1],
//            'product_name_en' => $row[4],
            'barcode' => $row[0],
//            'category_id' => ($cat)?$cat->id:null,
            'unit_id' => ($unit)?$unit->id:null,
            'product_status' => 1
//            'product_status' => ($row[16] == 'نعم') ? 1 : 0,
        ]);
//        if ($cat) {
//            return new ProductModel([
//                'product_id' => $row[0],
//                'product_name_ar' => $row[3],
//                'category_id' => $cat->id,
//                'product_status' => ($row[16] == 'نعم') ? 1 : 0,
//            ]);
//        }
//        if ($unit) {
//            return new ProductModel([
//                'product_id' => $row[0],
//                'product_name_ar' => $row[3],
//                'unit_id' => $unit->id,
//                'product_status' => ($row[16] == 'نعم') ? 1 : 0,
//            ]);
//        }
//            if (!$unit) {
//                $unit_data = new UnitsModel();
//                $unit_data->unit_name = $row[9];
//                $unit_data->save();
//            }
//
//            // Check if $cat exists and create it if it doesn't
//            if (!$cat) {
//                $car_data = new CategoryProductModel();
//                $car_data->cat_name = $row[6];
//                $car_data->save();
//            }

            // Create the ProductModel with the appropriate data
//            return new ProductModel([
//                'product_id' => $row[0],
//                'product_name_ar' => $row[3],
//                'unit_id' => $unit_data->id ?? null, // Use null if $unit was already set
//                'category_id' => $car_data->id ?? null, // Use null if $cat was already set
//                'product_status' => ($row[16] == 'نعم') ? 1 : 0,
//            ]);

    }

    public function startRow(): int
    {
        return 2;
    }
}
