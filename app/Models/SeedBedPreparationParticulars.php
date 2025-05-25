<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedBedPreparationParticulars extends Model
{
    use HasFactory;

    protected $fillable = [
        'seedbed_preparation_id',
        'activity',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function seedbedPreparation()
    {
        return $this->belongsTo(SeedbedPreparation::class);
    }

}
