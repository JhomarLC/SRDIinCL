<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_title',
        'training_date',
        'province_code',
        'municipality_code',
        'barangay_code',
        'status'
    ];

    public function getFullAddressAttribute()
    {
        $addressParts = [];

        if (!empty($this->house_number_sitio_purok)) {
            $addressParts[] = $this->house_number_sitio_purok;
        }

        $addressParts[] = optional($this->barangay)->name;
        $addressParts[] = optional($this->municipality)->name;
        $addressParts[] = optional($this->province)->name;
        $addressParts[] = $this->zip_code;

        return implode(', ', array_filter($addressParts));
    }

    public function getFormattedTrainingDateAttribute()
    {
        return Carbon::parse($this->training_date)->format('F j, Y');
    }

    public function training_evaluation() {
        return $this->hasMany(TrainingEvaluation::class, 'training_evaluation_id', 'code');
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
}
