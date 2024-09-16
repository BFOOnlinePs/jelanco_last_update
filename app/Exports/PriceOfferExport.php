<?php

namespace App\Exports;

use App\Models\OrderItemsModel;
use App\Models\PriceOfferModel;
use App\Models\PriceOffersModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PriceOfferExport implements FromCollection,WithHeadings
{
    protected $order_id;

    public function __construct($order_id){
        $this->order_id = $order_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OrderItemsModel::select('order_items.product_id','product.product_name_ar','order_items.qty')->join('product','order_items.product_id','=','product.id')->where('order_items.order_id',$this->order_id)->get();
    }

    public function headings(): array
    {
        // Define the column headings here
        return [
            'product_id',
            'product_name',
            'qty',
            'price'
        ];
    }
}
