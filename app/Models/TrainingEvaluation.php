<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_event_id',
        'status'
    ];
    public function training_event() {
        return $this->belongsTo(TrainingEvent::class);
    }

    public function training_content_evaluation() {
        return $this->hasOne(TrainingContentEvaluation::class);
    }

    public function course_management_evaluation() {
        return $this->hasOne(CourseManagementEvaluation::class);
    }

    public function overall_training_assessment() {
        return $this->hasOne(OverallTrainingAssessment::class);
    }

    public function training_participant_info() {
        return $this->hasOne(TrainingParticipantInfo::class);
    }

}
