<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedBedFertilizationParticulars extends Model
{
    use HasFactory;

    protected $fillable = [
        'seed_bed_fertilizations_id',
        'activity',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function fertilization()
    {
        return $this->belongsTo(SeedBedFertilizations::class, 'seed_bed_fertilization_id');
    }
}
