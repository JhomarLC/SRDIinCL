<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingResults extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id',
        'pre_test_score',
        'post_test_score',
        'total_test_items',
        'gain_in_knowledge',
        'certificate_type',
        'certificate_number',
        'overall_training_eval_score',
        'trainer_rating',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }
}
