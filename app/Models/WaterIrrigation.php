<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterIrrigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'water_management_id',
        'label',
        'method',
        'nia_total',
    ];

      // ✅ Correct relationship: WaterIrrigation has many details
    public function details()
    {
        return $this->hasMany(WaterIrrigationDetails::class, 'water_irrigation_id');
    }

    // Optional: If you want inverse relation to water management
    public function waterManagement()
    {
        return $this->belongsTo(WaterManagement::class, 'water_management_id');
    }

}
