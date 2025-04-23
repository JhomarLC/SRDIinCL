<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseManagementEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_evaluation_id',
        'coordination_score',
        'time_management_score',
        'speaker_quality_score',
        'facilitators_score',
        'support_staff_score',
        'materials_score',
        'facility_score',
        'accommodation_score',
        'food_quality_score',
        'transportation_score',
        'overall_management_score',
        'low_score_comment',
    ];

    protected $appends = ['overall_score'];

    public function training_evaluation() {
        return $this->belongsTo(TrainingEvaluation::class);
    }

    public function getOverallScoreAttribute()
    {
        $scores = [
            $this->coordination_score,
            $this->time_management_score,
            $this->speaker_quality_score,
            $this->facilitators_score,
            $this->support_staff_score,
            $this->materials_score,
            $this->facility_score,
            $this->accommodation_score,
            $this->food_quality_score,
            $this->transportation_score,
            $this->overall_management_score,
        ];

        $validScores = array_filter($scores, fn($score) => !is_null($score));

        return count($validScores) > 0
            ? round(array_sum($validScores) / count($validScores), 2)
            : null;
    }

}
