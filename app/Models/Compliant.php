<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Compliant extends Model
{
    use HasApiTokens, HasFactory;

    protected $guarded = [];

    // PACKAGES METHOD
    
    // RELATIONSHIPS
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function compliantReplies()
    {
        return $this->hasMany(ComplaintReplies::class, 'compliant_id', 'id');
    }
}

// $compliant->user
// $compliant->compliantReplies
