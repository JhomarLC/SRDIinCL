<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['code', 'name', 'province_code'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function barangays()
    {
        return $this->hasMany(Barangay::class, 'municipality_code', 'code');
    }
}
