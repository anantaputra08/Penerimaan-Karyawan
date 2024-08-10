<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'lokers_id',
        'applied_at',
        'application_file',
        'status',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Loker model
    public function loker()
    {
        return $this->belongsTo(Loker::class, 'lokers_id');
    }
}
