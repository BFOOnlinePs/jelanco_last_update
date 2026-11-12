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

    /**
     * بحث بالكلمات: كل كلمة لازم تكون موجودة بالاسم العربي او الانجليزي او الباركود، بأي مكان وبأي ترتيب
     * مثال: "سيريه كبير" تجيب "سيريه رش ابجل كبير - ذهبي"
     */
    public function scopeSearchWords($query, $search)
    {
        $words = preg_split('/\s+/u', trim((string) $search), -1, PREG_SPLIT_NO_EMPTY);
        foreach ($words as $word) {
            $query->where(function ($query) use ($word) {
                $query->where('product_name_ar', 'like', "%{$word}%")
                    ->orWhere('product_name_en', 'like', "%{$word}%")
                    ->orWhere('barcode', 'like', "%{$word}%");
            });
        }
        return $query;
    }
}
