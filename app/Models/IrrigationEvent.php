<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IrrigationEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_activity_id',
        'round_number',
        'irrigation_type',
        'is_pakyaw',
        'total_cost',
    ];

    public function farmingActivity()
    {
        return $this->belongsTo(FarmingActivity::class);
    }
}
