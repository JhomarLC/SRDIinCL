<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_activity_id',
        'round_number',
        'activity',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function activity()
    {
        return $this->belongsTo(FarmingActivity::class);
    }

    public function inputs()
    {
        return $this->hasMany(Input::class);
    }

    public function laborShare()
    {
        return $this->hasMany(LaborShare::class);
    }

    public function sacks()
    {
        return $this->hasMany(Sack::class);
    }
}
