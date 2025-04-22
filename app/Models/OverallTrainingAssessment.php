<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverallTrainingAssessment extends Model
{
    use HasFactory;
    protected $casts = [
        'notable_employees' => 'array',
    ];

    // [
    //     {
    //         "name": "John Doe",
    //         "impression": "positive",
    //         "reason": "Great team player and problem-solver."
    //     },
    //     {
    //         "name": "Jane Smith",
    //         "impression": "negative",
    //         "reason": "Frequent absenteeism and lack of communication."
    //     }
    // ]

}
