<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmingData extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'season',
        'year_training_conducted',
        'farm_size_hectares',
        'method_crop_establishment',
        'yield_tons_per_ha',
        'est_moisture_content_percent',
        'number_of_bags',
        'avg_weight_per_bag',
        'price_per_kg_fresh',
        'price_per_kg_dry',
        'drying_cost_per_bag',
        'total_yield_caban',
        'weight_per_caban_kg',
        'price_per_kg',
        'total_income',
        'total_cost',
        'other_crops',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function land_preparation()
    {
        return $this->hasOne(LandPreparation::class);
    }

    public function seeds_preparation()
    {
        return $this->hasOne(SeedsPreparation::class);
    }

    public function seedbed_preparation()
    {
        return $this->hasOne(SeedBedPreparation::class);
    }

    public function seedbed_fertilizations()
    {
        return $this->hasOne(SeedBedFertilizations::class);
    }

    public function crop_establishment()
    {
        return $this->hasOne(CropEstablishment::class);
    }

    public function fertilizer_applications()
    {
        return $this->hasMany(FertilizerApplication::class);
    }

    public function water_management()
    {
        return $this->hasOne(WaterManagement::class);
    }

    public function pesticide_applications()
    {
        return $this->hasOne(PesticideApplication::class);
    }

    public function harvest_management()
    {
        return $this->hasOne(HarvestManagement::class);
    }
}
