<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeakerTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'speaker_id',
        'topic_discussed',
        'topic_date',
        'status',
    ];

    public static function topicOptions(): array
    {
        return [
            // A. Overview
            'Overview of the PalayCheck System' => '1. Overview of the PalayCheck System',

            // C. Integrated Pest Management
            'IPM concepts and principles' => '1. IPM concepts and principles',
            'Insect Pests and Natural Enemies' => '2. Identification and Management of Insect Pests of Rice and their Natural Enemies',
            'Ecological Engineering' => '3. Ecological Engineering',
            'AESA concepts and procedures' => '4. Agroecosystems Analysis (AESA) concepts and procedures',
            'Other Pests Management' => '5. Other Pests (Weeds, GAS, Rodents) and their management',
            'Rice Disease Management' => '6. Identification and Management of Major Diseases of Rice',
            'PalayCheck Key Check 7' => '7. PalayCheck System Key check 7: No significant yield loss due to pests',

            // B. Integrated Nutrient Management
            'INM Concepts and Fertilizer Management' => '1. INM Concept and Principles; Nutrient Facts and Management (Organic and Inorganic Fertilizer Materials; Fertilizer Computation)',
            'MOET App' => '2. The MOET and the Use of MOET App',
            'LCC App' => '3. The Use of LCC App',
            'RCMAS' => '4. The use of RCMAS',
            'Abonong Swak' => '5. Abonong Swak',
            'PalayCheck Key Check 5' => '6. PalayCheck System Key Check 5: Sufficient nutrients from tillering to early panicle initiation and flowering',
        ];
    }

    public static function getTopicLabel(string $value): string
    {
        return self::topicOptions()[$value] ?? $value;
    }

    public function getFormattedTopicDateAttribute()
    {
        return Carbon::parse($this->topic_date)->format('F j, Y');
    }

    public function speaker_evaluation()
    {
        return $this->hasMany(SpeakerEvaluation::class, 'speaker_topic_id');
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class, 'speaker_id');
    }
}
