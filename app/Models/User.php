<?php

namespace App\Models;

use App\Contracts\Likeable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'birthday',
        'avatar',
        'cover',
    ];

    protected $dates = ['verified_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verified_at',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    public function isVerifiedAttribute() : bool
    {
        return $this->isVerified();
    }

    public function isVerified() : bool
    {
        return $this->verified_at instanceof Carbon;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addPost(Post $post)
    {
        $this->posts()->save($post);

        return $post;
    }

    public function hasBirthday() : bool
    {
        if (is_null($this->birthday))
        {
            return false;
        }

        $today = Carbon::today();

        return $today->month == $this->birthday;
    }

    public static function register(array $attributes)
    {
        $user = static::create($attributes);

        $user->fireModelEvent('registered');

        return $user;
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function like(Likeable $likeable)
    {
        $likeable->like($this);
    }

    public function unlike(Likeable $likeable)
    {
        $likeable->unlike($this);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function addPhoto(Photo $photo)
    {
        return $this->photos()->save($photo);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'user_id')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'followed_id')->withTimestamps();
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }

    public function isFollowedBy(User $user)
    {
        return $this->followers()->where('user_id', $user->id)->exists();
    }

    public function follow(User $user)
    {
        return $this->following()->attach($user);
    }

    public function unfollow(User $user)
    {
        return $this->following()->detach($user);
    }

    public function setPassword(string $password)
    {
        $this->password = bcrypt($password);
        $this->save();
    }

    public function getAccessToken()
    {
        return $this->token()->accessToken;
    }

    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] ?? asset('/img/generic-avatar.png');
    }

    public function getCoverAttribute()
    {
        return $this->attributes['cover'] ?? asset('/img/generic-cover.jpg');
    }
}
