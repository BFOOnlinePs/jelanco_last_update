<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceOffersModel extends Model
{
    use HasFactory;

    protected $table = 'price_offers';

    public function supplier(){
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }
}
