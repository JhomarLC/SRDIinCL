<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sack extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_detail_id',
        'type',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function detail()
    {
        return $this->belongsTo(ActivityDetail::class);
    }
}
