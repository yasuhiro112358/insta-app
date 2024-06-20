<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // follower user has many follows
    // followeds()ではダメなのか？
    // 若しくはfollowings()
    // public function follows()
    public function followings()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    // followed user has many followers
    public function followers()
    {
        return $this->hasMany(Follow::class, 'followed_id');
    }

    // Return true if $this user is being followed by auth user
    // return true if auth user is following $this user
    // これも「authIsFollowing()」の方が良い
    // public function isFollowing()
    public function authIsFollowing()
    {
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
    }

    public function userIsFollowingAuth()
    {
        return $this->followings()->where('followed_id', Auth::user()->id)->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

   
}
