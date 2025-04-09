<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeakerTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'speaker_id',
        'topic_discussed',
        'topic_date',
        'status',
    ];

    public function getFormattedTopicDateAttribute()
    {
        return Carbon::parse($this->topic_date)->format('F j, Y');
    }

    public function speaker_evaluation()
    {
        return $this->hasMany(SpeakerEvaluation::class, 'speaker_topic_id');
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class, 'speaker_id');
    }
}
