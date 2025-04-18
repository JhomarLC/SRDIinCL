<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeakerEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'speaker_topic_id',

        'knowledge_score',
        'teaching_method_score',
        'audiovisual_score',
        'clarity_score',
        'question_handling_score',
        'audience_connection_score',
        'content_relevance_score',
        'goal_achievement_score',

        'knowledge_score_comment',
        'teaching_method_comment',
        'audiovisual_comment',
        'clarity_comment',
        'question_handling_comment',
        'audience_connection_comment',
        'content_relevance_comment',
        'goal_achievement_comment',

        'additional_feedback',
        'status'
    ];

    protected $appends = ['overall_score'];

    public function getOverallScoreAttribute()
    {
        $total =
            + $this->knowledge_score
            + $this->teaching_method_score
            + $this->audiovisual_score
            + $this->clarity_score
            + $this->question_handling_score
            + $this->audience_connection_score
            + $this->content_relevance_score
            + $this->goal_achievement_score;

        return round($total / 8, 2); // Rounded average score (1.00 to 5.00)
    }

    public function speaker_topic()
    {
        return $this->belongsTo(SpeakerTopic::class, 'speaker_topic_id');
    }

    public function speaker_evaluation_info()
    {
        return $this->hasOne(SpeakerEvaluationsInfo::class, 'speaker_evaluation_id');
    }
}
