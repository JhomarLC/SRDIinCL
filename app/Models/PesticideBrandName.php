<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesticideBrandName extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesticide_application_id',
        'pesticide_type',
        'pesticide_name',
    ];

    public function pesticideApplication()
    {
        return $this->belongsTo(PesticideApplication::class);
    }
}
