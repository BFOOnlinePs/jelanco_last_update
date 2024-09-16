<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'id',
        'product_id',
        'product_name_ar',
        'product_name_en',
        'barcode',
        'category_id',
        'unit_id',
        'product_status'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItemsModel::class ,'product_id', 'id');
    }
}
