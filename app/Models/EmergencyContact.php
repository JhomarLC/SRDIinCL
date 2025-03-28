<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'relationship',
        'contact_number',
    ];


    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
}
