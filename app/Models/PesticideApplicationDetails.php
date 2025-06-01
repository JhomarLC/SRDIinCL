<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesticideApplicationDetails extends Model
{
    use HasFactory;

     protected $fillable = [
        'pesticide_application_id',
        'activity',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    public function pesticideApplication()
    {
        return $this->belongsTo(PesticideApplication::class);
    }

}
