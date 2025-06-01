<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesticideApplication extends Model
{
    use HasFactory;

   protected $fillable = [
        'farming_data_id',
        'label',
        'others',
    ];

    public function farmingData()
    {
        return $this->belongsTo(FarmingData::class);
    }

    public function details()
    {
        return $this->hasMany(PesticideApplicationDetails::class);
    }

    public function brandNames()
    {
        return $this->hasMany(PesticideBrandName::class);
    }
}
