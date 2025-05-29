<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedBedFertilizations extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_data_id',
        'others',
    ];

    public function particulars()
    {
        return $this->hasMany(SeedBedFertilizationParticulars::class);
    }

    public function fertilizers()
    {
        return $this->hasMany(SeedBedFertilizationFertilizers::class);
    }
}
