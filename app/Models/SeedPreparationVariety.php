<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedPreparationVariety extends Model
{
    use HasFactory;

    protected $fillable = [
        'seeds_preparation_id',
        'seed_variety_id',
        'variety_name',
        'purchase_type',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function seedsPreparation()
    {
        return $this->belongsTo(SeedsPreparation::class);
    }

    public function variety()
    {
        return $this->belongsTo(Variety::class, 'seed_variety_id');
    }
}
