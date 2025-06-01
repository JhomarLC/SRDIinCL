<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HarvestManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_data_id',
        'harvesting_type',
    ];

    public function farmingData()
    {
        return $this->belongsTo(FarmingData::class);
    }

    public function mechanical()
    {
        return $this->hasOne(HarvestMechanicalDetails::class);
    }

    public function manual()
    {
        return $this->hasOne(HarvestManualDetails::class);
    }
}
