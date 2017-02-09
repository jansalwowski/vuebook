<?php

namespace App\Models;

use App\Contracts\Commentable;
use App\Contracts\Likeable;
use App\Models\Maps\PostsTableMap;
use App\Models\Traits\HasComments;
use App\Models\Traits\HasLikes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements Likeable, Commentable
{
    use SoftDeletes, HasLikes, HasComments;

    protected $fillable = [
        'body',
        'user_id',
        'target_id',
        'type',
        'privacy_type',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'target_id' => 'integer',
    ];

    protected $appends = [
        'was_edited',
    ];

    protected $hidden = [
        'deleted_at',
        'privacy_type',
    ];

    protected $allowedTypes = PostsTableMap::AVAILABLE_TYPES;

    protected $allowedPrivacyTypes = PostsTableMap::AVAILABLE_PRIVACY_TYPES;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTypeAttribute(string $type = null)
    {
        if (null === $type) {
            $type = PostsTableMap::TYPE_TEXT;
        }

        $this->setType($type);
    }

    public function setType(string $type)
    {
        if (false === in_array($type, $this->allowedTypes)) {
            $type = PostsTableMap::TYPE_TEXT;
        }

        $this->attributes['type'] = $type;
    }

    public function setPrivacyTypeAttribute(string $type = null)
    {
        if (null === $type) {
            $type = PostsTableMap::PRIVACY_PUBLIC;
        }

        $this->setPrivacyType($type);
    }

    public function setPrivacyType(string $type)
    {
        if (false === in_array($type, $this->allowedPrivacyTypes)) {
            $type = PostsTableMap::PRIVACY_PUBLIC;
        }

        $this->attributes['privacy_type'] = $type;
    }

    public function setTargetIdAttribute($targetId)
    {
        $this->attributes['target_id'] = $this->user_id === $targetId ? null : $targetId;
    }

    public function setTarget(User $user)
    {
        $this->target()->associate($user);
    }

    public function target()
    {
        return $this->belongsTo(User::class);
    }

    public function getWasEditedAttribute()
    {
        return $this->updated_at instanceof Carbon && $this->updated_at->gt($this->created_at);
    }
}
