<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotableEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'overall_training_assessment_id',
        'employee_name',
        'employee_reason',
    ];

    public function overall_training_assessment() {
        return $this->belongsTo(OverallTrainingAssessment::class);
    }
}
