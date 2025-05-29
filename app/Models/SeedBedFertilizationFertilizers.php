<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedBedFertilizationFertilizers extends Model
{
    use HasFactory;

    protected $fillable = [
        'seed_bed_fertilization_id',
        'fertilizer_name',
        'purchase_type',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function fertilization()
    {
        return $this->belongsTo(SeedBedFertilizations::class, 'seed_bed_fertilization_id');
    }
}
