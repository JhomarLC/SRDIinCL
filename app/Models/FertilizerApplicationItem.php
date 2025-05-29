<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FertilizerApplicationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'fertilizer_application_id',
        'fertilizer_name',
        'purchase_type',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function application()
    {
        return $this->belongsTo(FertilizerApplication::class);
    }

}
