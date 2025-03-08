<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AewsProfile extends Model
{
    use HasFactory;

    protected $fillable = ['position_id', 'employment_type_id', 'contact_number', 'start_date', 'end_date', 'job_status'];

    protected $appends = ['years_of_service'];

    // Compute years of service dynamically
    public function getYearsOfServiceAttribute()
    {
        $startDate = Carbon::parse($this->start_date);
        $endDate = $this->end_date ? Carbon::parse($this->end_date) : now(); // If resigned/retired, use end_date

        return $startDate->diffInYears($endDate);
    }

    public function updateStatus()
    {
        if (in_array($this->job_status, ['resigned', 'retired', 'transferred'])) {
            return; // Don't update if already left
        }

        $this->update(['job_status' => ($this->years_of_service < 1) ? 'new' : 'old']);
    }

    public function employment_type()
    {
        return $this->belongsTo(EmploymentType::class, 'employment_type_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'profile_training');
    }
}