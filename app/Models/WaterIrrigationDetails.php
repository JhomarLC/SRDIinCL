<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterIrrigationDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'water_irrigation_id',
        'activity',
        'qty',
        'unit_cost',
        'total_cost'
    ];

    // ✅ Correct relationship: belongs to one irrigation
    public function irrigation()
    {
        return $this->belongsTo(WaterIrrigation::class, 'water_irrigation_id');
    }

}
