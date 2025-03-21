<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingResults extends Model
{
    use HasFactory;

    public function participant()
    {
        return $this->belongsToMany(Participant::class, 'participant_id');
    }
}
