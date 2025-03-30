<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'nickname',
        'phone_number',
        'birth_date',
        'age_group',
        'is_pwd',
        'disability_type',
        'gender',
        'civil_status',
        'religion',
        'is_indigenous',
        'tribe_name',
        'province_code',
        'municipality_code',
        'barangay_code',
        'zip_code',
        'house_number_sitio_purok',
        'primary_sector',
        'years_in_farming',
        'farmer_association',
        'education_level',
        'farm_role',
        'rsbsa_number',
    ];
    public function region() {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function province() {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function municipality() {
        return $this->belongsTo(Municipality::class, 'municipality_code', 'code');
    }

    public function barangay() {
        return $this->belongsTo(Barangay::class, 'barangay_code', 'code');
    }

    public function training_attendance()
    {
        return $this->hasMany(TrainingAttendance::class, 'participant_id');
    }

    public function food_restrictions()
    {
        return $this->hasMany(FoodRestrictions::class, 'participant_id');
    }

    public function medical_conditions()
    {
        return $this->hasMany(MedicalConditions::class, 'participant_id');
    }

    public function farming_data()
    {
        return $this->hasMany(FarmingData::class, 'participant_id');
    }

    public function emergency_contact()
    {
        return $this->hasOne(EmergencyContact::class, 'participant_id');
    }

    public function training_results()
    {
        return $this->hasMany(TrainingResults::class, 'participant_id');
    }
}
