<?php
//@formatter:off
declare(strict_types = 1);
//@formatter:on


namespace App\Models\Traits;


use App\Exceptions\Models\ResourceCannotBeLikedTwiceException;
use App\Exceptions\Models\ResourceCannotBeUnlikedException;
use App\Models\Like;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

trait HasLikes
{

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like(User $user = null)
    {
        $user = $this->getUser($user);

        if ($this->isLikedBy($user)) {
            throw new ResourceCannotBeLikedTwiceException();
        }

        $like = new Like([
            'user_id' => $user->id,
        ]);

        $this->likes()->save($like);
    }

    public function unlike(User $user = null)
    {
        $user = $this->getUser($user);

        if (false === $this->isLikedBy($user)) {
            throw new ResourceCannotBeUnlikedException();
        }

        $this->likes()->whereUserId($user->id)->delete();
    }

    public function hasLikes()
    {
        return $this->likes()->exists();
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->whereUserId($user->id)->exists();
    }

    protected function getUser(User $user = null): User
    {
        if ($user instanceof User) {
            return $user;
        }

        if (\Auth::guest()) {
            throw new AuthorizationException();
        }

        return \Auth::user();
    }
}