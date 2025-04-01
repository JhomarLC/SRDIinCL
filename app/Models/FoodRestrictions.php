<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodRestrictions extends Model
{
    use HasFactory;
    protected $fillable = ['participant_id', 'food_restriction'];
    public function participants()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
}
