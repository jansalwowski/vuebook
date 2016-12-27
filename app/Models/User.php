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
}
