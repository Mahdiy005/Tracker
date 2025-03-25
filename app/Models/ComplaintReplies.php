<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ComplaintReplies extends Model
{
    use HasApiTokens, HasFactory;

    protected $guarded = [];

    // PACKAGES METHOD
    
    // RELATIONSHIPS
    public function compliant()
    {
        return $this->belongsTo(Compliant::class, 'compliant_id', 'id');
    }

    public function adminUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

// $complaint_replies->compliant   `compliants`
// $complaint_replies->admin_user  `only admin`
