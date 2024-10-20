<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'orders';
    protected $fillable = ['order_status'];

/*************  ✨ Codeium Command ⭐  *************/
    /**
     * Belongs to user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
/******  79eae72c-7b55-4f3f-9396-2ce8d7883a1a  *******/
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function priceOffers(){
        return $this->hasMany(PriceOffersModel::class, 'order_id', 'id')->select('supplier_id')->where('status', 1);
    }
}
