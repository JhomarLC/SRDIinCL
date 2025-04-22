<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvaluation extends Model
{
    use HasFactory;

    public function training_event() {
        return $this->belongsTo(TrainingEvent::class, 'training_event_id', 'code');
    }
}
