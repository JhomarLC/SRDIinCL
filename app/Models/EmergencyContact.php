<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
}
