<?php

namespace App\Models;

use App\Contracts\Likeable;
use App\Models\Traits\HasLikes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model implements Likeable
{
    use SoftDeletes, HasLikes;

    protected $fillable = [
        'body',
        'user_id',
        'commentable_type',
        'commentable_id',
    ];

    protected $casts = [
        'commentable_type' => 'int',
        'commentable_id' => 'int',
        'likes_count' => 'int',
        'user_id' => 'int',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
