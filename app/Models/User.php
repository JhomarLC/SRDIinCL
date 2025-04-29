<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// implements MustVerifyEmail
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'email',
        'password',
        'role',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly([
    //         'first_name',
    //         'middle_name',
    //         'last_name',
    //         'suffix',
    //         'email',
    //         'role',
    //         'status'
    //     ])
    //     ->logOnlyDirty();
    // }

    public function profile()
    {
        return $this->hasOne(AewsProfile::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAew()
    {
        return $this->role === 'aews';
    }
    public function isProvincialAew()
    {
        $position = optional(optional($this->profile)->position)->position_name;
        $provincialPositions = [
            'Rice AEW Provincial',
            'Provincial Agriculturist',
        ];
        return $this->isAew() && in_array($position, $provincialPositions);
    }

    public function isMunicipalAew()
    {
        $position = optional(optional($this->profile)->position)->position_name;
        $municipalPositions = [
            'Rice AEW Municipal/City',
            'Municipal/City Agriculturist',
        ];
        return $this->isAew() && in_array($position, $municipalPositions);
    }


}
