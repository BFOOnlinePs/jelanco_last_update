<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceOfferItemsModel extends Model
{
    use HasFactory;

    protected $table = 'price_offer_items';

    protected $fillable = [
        'id','order_id','supplier_id','product_id','price','qty'
    ];

    public function order()
    {
        return $this->belongsTo(OrderModel::class , 'order_id' , 'id');
    }
}
