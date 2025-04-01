<?php

namespace App\Models;

use Carbon\Carbon;
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
    // In Participants.php model
    public function getFullNameAttribute()
    {
        $middleName = $this->middle_name ? ' ' . $this->middle_name : '';
        $suffix = $this->suffix ? ' ' . $this->suffix : '';
        return "{$this->first_name}{$middleName} {$this->last_name}{$suffix}";
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }
    public function getRecentGikAttribute()
    {
        $recentTraining = $this->trainings()->latest()->first();

        return optional($recentTraining?->training_result)->gain_in_knowledge;
    }


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

    public function trainings()
    {
        return $this->hasMany(Training::class, 'participant_id');
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
