<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteriaModel extends Model
{
    use HasFactory;

    protected $table = 'evaluation_criteria';

    protected $guarded = [];

    public function evaluation()
    {
        return $this->belongsTo(EvaluationModel::class, 'evaluation_id', 'id');
    }

    public function criteria()
    {
        return $this->belongsTo(CriteriaModel::class, 'criteria_id', 'id');
    }
}
