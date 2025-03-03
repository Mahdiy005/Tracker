<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ActivityLog extends Model
{
    use HasApiTokens, HasFactory;

    protected $guarded = [];

    // PACKAGES METHOD
    
    // RELATIONSHIPS
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

// $activityLog->user
