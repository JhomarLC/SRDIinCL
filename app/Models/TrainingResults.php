<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingResults extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_title_main',
        'training_date_main',
        'ts_province_code',
        'ts_municipality_code',
        'ts_barangay_code',
        'participant_id',
        'pre_test_score',
        'post_test_score',
        'total_test_items',
        'gain_in_knowledge',
        'certificate_type',

        'total_no_meetings',
        'meetings_attended',
        'percentage_meetings_attended',

        'certificate_number',
        'overall_training_eval_score',
        'trainer_rating',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function getFullAddressAttribute()
    {
        $addressParts = [];

        $addressParts[] = optional($this->barangay)->name;
        $addressParts[] = optional($this->municipality)->name;
        $addressParts[] = optional($this->province)->name;

        return implode(', ', array_filter($addressParts));
    }
    public function getTrainingDateMainFormattedAttribute()
    {
        return $this->training_date_main
            ? Carbon::parse($this->training_date_main)->format('F j, Y') // e.g. "April 7, 2025"
            : null;
    }

    public function region() {
        return $this->belongsTo(Region::class, 'ts_region_code', 'code');
    }

    public function province() {
        return $this->belongsTo(Province::class, 'ts_province_code', 'code');
    }

    public function municipality() {
        return $this->belongsTo(Municipality::class, 'ts_municipality_code', 'code');
    }

    public function barangay() {
        return $this->belongsTo(Barangay::class, 'ts_barangay_code', 'code');
    }
}
