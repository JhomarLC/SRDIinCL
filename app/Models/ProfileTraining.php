<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileTraining extends Model
{
    public function profiles()
    {
        return $this->belongsToMany(AewsProfile::class, 'profile_training');
    }

    use HasFactory;
}