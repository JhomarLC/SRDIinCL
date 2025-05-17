<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Input extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_detail_id',
        'input_type',
        'brand_name',
        'is_free',
    ];

    public function activityDetail()
    {
        return $this->belongsTo(ActivityDetail::class);
    }
}
