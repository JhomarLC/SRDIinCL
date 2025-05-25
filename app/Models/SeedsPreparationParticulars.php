<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedsPreparationParticulars extends Model
{
    use HasFactory;

    protected $fillable = [
        'seeds_preparation_id',
        'activity',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function seedsPreparation()
    {
        return $this->belongsTo(SeedsPreparation::class);
    }

}
