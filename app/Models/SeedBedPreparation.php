<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedBedPreparation extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_data_id',
        'is_pakyaw',
        'package_cost',
    ];


    public function particulars()
    {
        return $this->hasMany(SeedBedPreparationParticulars::class);
    }

}
