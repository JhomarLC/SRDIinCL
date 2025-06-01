<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HarvestMechanicalDetails extends Model
{
    use HasFactory;

     protected $fillable = [
        'harvest_management_id',
        'bags',
        'avg_bag_weight',
        'price_per_kg',
        'total_cost',
    ];

    public function harvestManagement()
    {
        return $this->belongsTo(HarvestManagement::class);
    }
}
