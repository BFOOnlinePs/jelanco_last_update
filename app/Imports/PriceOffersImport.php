<?php

namespace App\Imports;

use App\Models\PriceOfferItemsModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PriceOffersImport implements ToModel, WithHeadingRow
{
    protected $order_id;
    protected $supplier_id;

    public function __construct($order_id, $supplier_id)
    {
        $this->order_id = $order_id;
        $this->supplier_id = $supplier_id;
    }

    public function model(array $row)
    {
        $find = PriceOfferItemsModel::where('order_id', $this->order_id)
            ->where('supplier_id', $this->supplier_id)->where('product_id',$row['product_id'])
            ->first();
            if ($find){
                $find->update([
                        'price' => $row['price'], // Update the 'price' column with the value from the current Excel row
                    ]);
            }

//        foreach ($row as $column => $value) {
//            $counter = 0;
//            if ($column === 'price') {
//                $price[] = $value; // Access the value of the "price" column
//                // Now you can perform any desired operations using the $price value
//            }
//        }
//        $find = PriceOfferItemsModel::where('order_id', $this->order_id)
//            ->where('supplier_id', $this->supplier_id)
//            ->get();
//        if ($find->isNotEmpty()) {
//            foreach ($find as $index => $item) {
//                if (isset($row[$index]['price'])) {
//                    $item->update([
//                        'price' => $row[$index]['price'], // Update the 'price' column with the value from the current Excel row
//                    ]);
//                }
//            }
//        }
    }

}
