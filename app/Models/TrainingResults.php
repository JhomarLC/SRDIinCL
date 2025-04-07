<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingResults extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_title_main',
        'training_date_main',
        'training_location_main',
        'participant_id',
        'pre_test_score',
        'post_test_score',
        'total_test_items',
        'gain_in_knowledge',
        'certificate_type',
        'certificate_number',
        'overall_training_eval_score',
        'trainer_rating',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function getTrainingDateMainFormattedAttribute()
    {
        return $this->training_date_main
            ? Carbon::parse($this->training_date_main)->format('F j, Y') // e.g. "April 7, 2025"
            : null;
    }


}
