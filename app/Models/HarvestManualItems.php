<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HarvestManualItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'harvest_manual_detail_id',
        'activity',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function manualDetail()
    {
        return $this->belongsTo(HarvestManualDetails::class, 'harvest_manual_detail_id');
    }
}
