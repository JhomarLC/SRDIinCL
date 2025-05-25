<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandPreparation extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_data_id',
        'is_pakyaw',
        'package_cost',
    ];

    // Optional: Relationships
    public function particulars()
    {
        return $this->hasMany(LandPreparationParticulars::class);
    }

    public function farmingData()
    {
        return $this->belongsTo(FarmingData::class);
    }
}
