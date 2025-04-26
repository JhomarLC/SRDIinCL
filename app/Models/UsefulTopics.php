<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulTopics extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_content_evaluation_id',
        'topic_name',
    ];

    public function training_content_evaluation() {
        return $this->belongsTo(TrainingContentEvaluation::class);
    }

}
