<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loker extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'department_id',
        'position_id',
        'max_applicants',
        'salary',
        'description',
        'photo',
        'statement_letter',
    ];

    /**
     * Get the department that owns the loker.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the position that owns the loker.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'lokers_id');
    }

    public function getCurrentApplicantsCountAttribute()
    {
        return $this->hasMany(JobApplication::class, 'lokers_id')->count();
    }
}
