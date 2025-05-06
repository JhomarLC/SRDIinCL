<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeakerEvaluationsInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'age_group',
        'is_pwd',
        'disability_type',
        'is_indigenous',
        'tribe_name',
        'gender',
        'province_code',
        'primary_sector',
    ];

    public function getFullNameAttribute()
    {
        $middleName = $this->middle_name ? ' ' . $this->middle_name : '';
        $suffix = $this->suffix ? ' ' . $this->suffix : '';
        return "{$this->first_name} {$middleName} {$this->last_name} {$suffix}";
    }

    public function speaker_evaluation()
    {
        return $this->belongsTo(SpeakerEvaluation::class, 'speaker_evaluation_id');
    }
}
