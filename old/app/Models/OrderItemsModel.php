<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemsModel extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    public function unit()
    {
        return $this->belongsTo(UnitsModel::class , 'unit_id' , 'id');
    }
}
