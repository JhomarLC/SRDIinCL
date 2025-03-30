<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['code', 'name', 'region_code'];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'province_code', 'code');
    }
}
