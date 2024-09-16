<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemsModel extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id','product_id','qty','unit_id','notes','status'
    ];

    public function unit()
    {
        return $this->belongsTo(UnitsModel::class , 'unit_id' , 'id');
    }

    public function order(){
        return $this->belongsTo(OrderModel::class,'order_id','id');
    }
}
