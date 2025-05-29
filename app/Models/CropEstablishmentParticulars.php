<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropEstablishmentParticulars extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_establishment_id',
        'activity',
        'qty',
        'unit_cost',
        'total_cost'
    ];

    public function cropEstablishment()
    {
        return $this->belongsTo(CropEstablishment::class);
    }

}
