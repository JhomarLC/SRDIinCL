<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingContentEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_evaluation_id',
        'objective_score',
        'relevance_score',
        'content_completeness_score',
        'lecture_hands_on_score',
        'sequence_score',
        'duration_score',
        'assessment_method_score',
        'low_score_comment',
    ];

    protected $appends = ['overall_score'];

     /**
     * Accessor: Calculate the average of the scores
     */
    public function getOverallScoreAttribute()
    {
        $scores = [
            $this->objective_score,
            $this->relevance_score,
            $this->content_completeness_score,
            $this->lecture_hands_on_score,
            $this->sequence_score,
            $this->duration_score,
            $this->assessment_method_score,
        ];

        $validScores = array_filter($scores, fn($score) => !is_null($score));

        return count($validScores) > 0
            ? round(array_sum($validScores) / count($validScores), 2)
            : null;
    }

    public function training_evaluation() {
        return $this->belongsTo(TrainingEvaluation::class);
    }

}
