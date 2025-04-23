<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulTopics extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_evaluation_id',
        'topic_name',
    ];


    public function training_evaluation() {
        return $this->belongsTo(TrainingEvaluation::class);
    }

}
