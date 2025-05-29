<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropEstablishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_data_id',
        'method',
        'establishment_type',
        'is_pakyaw',
        'package_total_cost'
    ];

    public function particulars()
    {
        return $this->hasMany(CropEstablishmentParticulars::class);
    }

}
