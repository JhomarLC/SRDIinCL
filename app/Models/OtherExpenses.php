<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherExpenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_data_id',
        'hauling_qty',
        'hauling_unit_cost',
        'hauling_total_cost',
        'hired_bags',
        'hired_avg_bag_weight',
        'hired_price_per_kg',
        'hired_percent_share',
        'hired_total_cost',
        'land_ownership_fee',
    ];

    public function farmingData()
    {
        return $this->belongsTo(FarmingData::class);
    }
}
