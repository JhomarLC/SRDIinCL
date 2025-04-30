<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverallTrainingAssessment extends Model
{
    use HasFactory;
    protected $fillable = [
        'training_evaluation_id',
        'goal_achievement',
        'overall_quality',
        'additional_feedback_or_suggestions',
        'recommend_training',
        'recommendation_reason',
        'preferred_future_trainings'
    ];

    public function training_evaluation() {
        return $this->belongsTo(TrainingEvaluation::class);
    }

    public function notable_employees() {
        return $this->hasMany(NotableEmployee::class);
    }
}
