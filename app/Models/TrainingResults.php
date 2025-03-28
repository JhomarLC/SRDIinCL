<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingResults extends Model
{
    use HasFactory;

    protected $fillable = [
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
        return $this->belongsToMany(Participant::class, 'participant_id');
    }
}
