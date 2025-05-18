<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FarmingActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_data_id',
        'category',
        'method',
        'is_pakyaw',
        'total_cost',
    ];

    public function farmingData()
    {
        return $this->belongsTo(FarmingData::class);
    }

    public function details()
    {
        return $this->hasMany(ActivityDetail::class);
    }

    public function irrigationEvents()
    {
        return $this->hasMany(IrrigationEvent::class);
    }
}
