<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverallTrainingAssessment extends Model
{
    use HasFactory;
    protected $casts = [
        'notable_employees' => 'array',
    ];

    protected $fillable = [
        'training_evaluation_id',
        'goal_achievement',
        'overall_quality',
        'recommend_training',
        'recommendation_reason',
    ];
    // [
    //     {
    //         "name": "John Doe",
    //         "impression": "positive",
    //         "reason": "Great team player and problem-solver."
    //     },
    //     {
    //         "name": "Jane Smith",
    //         "impression": "negative",
    //         "reason": "Frequent absenteeism and lack of communication."
    //     }
    // ]
    public function training_evaluation() {
        return $this->belongsTo(TrainingEvaluation::class);
    }

}
