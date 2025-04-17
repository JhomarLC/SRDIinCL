<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'status'
    ];
    protected $appends = [
        'full_name',
        'overall_evaluation_score',
        'topic_evaluations_summary',
    ];

    public function getFullNameAttribute()
    {
        $middleName = $this->middle_name ? ' ' . $this->middle_name : '';
        $suffix = $this->suffix ? ' ' . $this->suffix : '';
        return "{$this->first_name}{$middleName} {$this->last_name}{$suffix}";
    }
    public function speaker_topics()
    {
        return $this->hasMany(SpeakerTopic::class, 'speaker_id');
    }

    public function getOverallEvaluationScoreAttribute()
    {
        $evaluations = $this->speaker_topics->where('status', 'active')->flatMap->speaker_evaluation->where('status', 'active');

        if ($evaluations->isEmpty()) {
            return null;
        }

        return round($evaluations->avg('overall_score'), 2);
    }

    public function getTopicEvaluationsSummaryAttribute()
    {
        return $this->speaker_topics->map(function ($topic) {
            $evaluations = $topic->speaker_evaluation;
            $average = $evaluations->avg('overall_score');

            return [
                'topic_id' => $topic->id,
                'topic_discussed' => $topic->topic_discussed,
                'formatted_topic_date' => $topic->formatted_topic_date,
                'average_score' => $evaluations->isNotEmpty() ? round($average, 2) : null,
                'evaluation_count' => $evaluations->count(),
            ];
        });
    }
}
