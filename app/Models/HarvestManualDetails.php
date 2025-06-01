<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HarvestManualDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'harvest_management_id',
        'is_package',
        'package_total_cost',
    ];

    public function harvestManagement()
    {
        return $this->belongsTo(HarvestManagement::class);
    }

    public function items()
    {
        return $this->hasMany(HarvestManualItems::class, 'harvest_manual_detail_id');
    }
}
