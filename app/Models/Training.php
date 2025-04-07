<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    // public function aews_profile()
    // {
    //     return $this->belongsTo(AewsProfile::class);
    // }

    use HasFactory;
    protected $fillable = [
        'participant_id',
        'training_title',
        'training_date',
        'conducted_by',
        'personally_paid',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function training_result()
    {
        return $this->hasOne(TrainingResults::class, 'training_id');
    }

    // Accessor for formatted training_date
    public function getTrainingDateFormattedAttribute()
    {
        return Carbon::parse($this->training_date)->format('F d, Y');
    }
}
