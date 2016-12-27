<?php
//@formatter:off
declare(strict_types = 1);
//@formatter:on


namespace App\Models\Traits;


use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

trait HasComments
{

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function comment(string $message, User $user = null)
    {
        $user = $this->getUser($user);

        $comment = new Comment([
            'body' => $message,
            'user_id' => $user->id,
        ]);

        $this->comments()->save($comment);

        return $comment;
    }

    public function hasComments()
    {
        return $this->comments()->exists();
    }
}