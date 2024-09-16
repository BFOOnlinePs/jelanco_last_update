<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierNotesModel extends Model
{
    use HasFactory;

    protected $table = 'supplier_notes';

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id' , 'id');
    }
}
