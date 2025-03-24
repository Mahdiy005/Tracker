<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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
        'password' => 'hashed',
    ];


    // RELATIONSHIPS
    public function attendances()
    {
        $this->hasMany(Attendance::class, 'user_id', 'id');
    }

    public function vilations()
    {
        $this->hasMany(Vilation::class, 'user_id', 'id');
    }

    public function trainedImages()
    {
        return $this->hasMany(TrainedImage::class);
    }

    public function actvityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id', 'id');
    }

    public function compliants()
    {
        return $this->hasMany(Compliant::class, 'user_id', 'id');
    }

    public function compliantReplies()
    {
        return $this->hasMany(ComplaintReplies::class, 'compliant_id', 'id');
    }
}


// $user->attendances
// $user->vilations
// $user->activityLog ~> current activity for the user 
// $user->trainedImages 
// $user->actvityLogs 
// $user->compliants 
// $user->compliantReplies  `Only Available for admin`
