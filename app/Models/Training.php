<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    public function aews_profile()
    {
        return $this->belongsTo(AewsProfile::class);
    }

    use HasFactory;
}