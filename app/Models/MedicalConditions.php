<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalConditions extends Model
{
    use HasFactory;
    protected $fillable = ['participant_id', 'medical_condition'];
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
}
