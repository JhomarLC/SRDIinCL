<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeakerEvaluation extends Model
{
    use HasFactory;
    protected $appends = ['overall_score'];

    public function getOverallScoreAttribute()
    {
        $total = $this->teaching_method_score
            + $this->audiovisual_score
            + $this->clarity_score
            + $this->question_handling_score
            + $this->audience_connection_score
            + $this->content_relevance_score
            + $this->goal_achievement_score;

        return round($total / 7, 2); // Rounded average score (1.00 to 5.00)
    }

    public function speaker_topic()
    {
        return $this->belongsTo(SpeakerTopic::class, 'speaker_topic_id');
    }
}
