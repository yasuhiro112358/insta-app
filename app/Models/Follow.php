<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    public $timestamps = false;

    // followedUser()とするのが筋かと
    // public function followed()
    public function followedUser()
    {
        return $this->belongsTo(User::class, 'followed_id')->withTrashed();
    }

    // follow belongs to follower user
    // followerUser()とするのが筋かと
    // public function follower()
    public function followerUser()
    {
        return $this->belongsTo(User::class, 'follower_id')->withTrashed();
    }
}
