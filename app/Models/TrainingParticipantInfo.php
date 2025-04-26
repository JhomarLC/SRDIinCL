<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingParticipantInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'age_group',
        'sex',
        'province_code',
        'primary_sector'
    ];

    public function training_evaluation() {
        return $this->belongsTo(TrainingEvaluation::class);
    }

}
