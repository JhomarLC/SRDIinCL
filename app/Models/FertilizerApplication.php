<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FertilizerApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_data_id',
        'label',
        'others'
    ];

    public function items()
    {
        return $this->hasMany(FertilizerApplicationItem::class);
    }

    public function labors()
    {
        return $this->hasMany(FertilizerApplicationLabor::class);
    }

}
