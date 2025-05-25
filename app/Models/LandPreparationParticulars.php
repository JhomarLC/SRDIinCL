<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandPreparationParticulars extends Model
{
    use HasFactory;

    protected $fillable = [
        'land_preparation_id',
        'activity',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function landPreparation()
    {
        return $this->belongsTo(LandPreparation::class);
    }
}
