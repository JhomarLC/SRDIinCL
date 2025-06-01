<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_data_id',
        'type',
        'is_package',
        'package_total_cost',
        'nia_total_amount'
    ];

   // ✅ A WaterManagement has many WaterIrrigations
    public function irrigations()
    {
        return $this->hasMany(WaterIrrigation::class, 'water_management_id');
    }

    // Optional: If you want to access its farming data
    public function farmingData()
    {
        return $this->belongsTo(FarmingData::class, 'farming_data_id');
    }

}
