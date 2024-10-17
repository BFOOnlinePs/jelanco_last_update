<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationModel extends Model
{
    use HasFactory;

    protected $table = 'evaluations';

    protected $guarded = [];

    public function evaluation_criteria()
    {
        return $this->hasMany(EvaluationCriteriaModel::class, 'evaluation_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
