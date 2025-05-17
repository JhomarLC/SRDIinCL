<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaborShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_detail_id',
        'bags',
        'avg_bag_weight',
        'price_per_kilo',
        'share_percent',
        'computed_total',
    ];

    public function activityDetail()
    {
        return $this->belongsTo(ActivityDetail::class);
    }
}
