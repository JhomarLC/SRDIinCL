<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeakerEvaluation extends Model
{
    use HasFactory;

    public function speaker_topic()
    {
        return $this->belongsTo(SpeakerTopic::class, 'speaker_topic_id');
    }
}
