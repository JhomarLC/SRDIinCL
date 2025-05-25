<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedsPreparation extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_data_id',
        'is_pakyaw',
        'package_cost',
        'others',
    ];

    public function particulars()
    {
        return $this->hasMany(SeedsPreparationParticulars::class);
    }

    public function seedVarieties()
    {
        return $this->hasMany(SeedPreparationVariety::class);
    }

    public function farmingData()
    {
        return $this->belongsTo(FarmingData::class);
    }
}
