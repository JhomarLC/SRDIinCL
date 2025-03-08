<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function aews_profiles()
    {
        return $this->hasMany(AewsProfile::class, 'position_id');
    }

    use HasFactory;
}