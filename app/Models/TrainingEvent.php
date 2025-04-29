<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_title',
        'training_date',
        'province_code',
        'municipality_code',
        'barangay_code',
        'status'
    ];

    public function getFullAddressAttribute()
    {
        $addressParts = [];

        if (!empty($this->house_number_sitio_purok)) {
            $addressParts[] = $this->house_number_sitio_purok;
        }

        $addressParts[] = optional($this->barangay)->name;
        $addressParts[] = optional($this->municipality)->name;
        $addressParts[] = optional($this->province)->name;
        $addressParts[] = $this->zip_code;

        return implode(', ', array_filter($addressParts));
    }

    public function getFormattedTrainingDateAttribute()
    {
        return Carbon::parse($this->training_date)->format('F j, Y');
    }


     // 🧮 Get average training content score
    public function getAvgContentScoreAttribute()
    {
        $scores = $this->evaluations
            ->where('status', 'active')
            ->pluck('training_content_evaluation.overall_score')
            ->filter();

        return $scores->count() ? round($scores->avg(), 2) : null;
    }

    // 🧮 Get average course management score
    public function getAvgCourseScoreAttribute()
    {
        $scores = $this->evaluations
        ->where('status', 'active')
            ->pluck('course_management_evaluation.overall_score')
            ->filter();

        return $scores->count() ? round($scores->avg(), 2) : null;
    }

    // 🥇 Get most common goal achievement
    public function getMostCommonGoalAchievementAttribute()
    {
        $goals = $this->evaluations
        ->where('status', 'active')
            ->pluck('overall_training_assessment.goal_achievement')
            ->filter();

        $modes = $goals->count() ? collect($goals->mode()) : collect();

        return $modes->isNotEmpty()
            ? $modes->implode(', ') // Returns all ties, comma-separated
            : 'No Evaluations';
    }

    // 🌟 Get most common overall quality
    public function getMostCommonOverallQualityAttribute()
    {
        $qualities = $this->evaluations
        ->where('status', 'active')
            ->pluck('overall_training_assessment.overall_quality')
            ->filter();

        $modes = $qualities->count() ? collect($qualities->mode()) : collect();

        return $modes->isNotEmpty()
            ? $modes->implode(', ')  // Show all ties as comma-separated
            : 'No Evaluations';
    }

    public function evaluations() {
        return $this->hasMany(TrainingEvaluation::class);
    }

    public function province() {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function municipality() {
        return $this->belongsTo(Municipality::class, 'municipality_code', 'code');
    }

    public function barangay() {
        return $this->belongsTo(Barangay::class, 'barangay_code', 'code');
    }
}
