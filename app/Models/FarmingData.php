<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmingData extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'season',
        'year_training_conducted',
        'farm_size_hectares',
        'total_yield_caban',
        'weight_per_caban_kg',
        'price_per_kg',
        'total_income',
        'total_cost',
        'other_crops',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
}
