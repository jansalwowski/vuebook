<?php
//@formatter:off
declare(strict_types = 1);
//@formatter:on


namespace App\Services\Repositories;


use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PostRepository
{
    const DEFAULT_LIMIT = 10;

    /**
     * @return Post[]
     */
    public function getUserPosts(User $user, int $lastId = null): Collection
    {
        // user_id = my , target_id = null || my
        // user_id != my , target_id = my
        $query = Post::latest()
            ->where(function (Builder $q) use ($user) {
                $q
                    ->where('target_id', $user->id)
                    ->orWhere('user_id', $user->id);
            })
            ->limit(self::DEFAULT_LIMIT)
            ->when($lastId, function (Builder $q) use ($lastId) {
                $q->where('id', '<', $lastId);
            });

        return $query->get();
    }

    /**
     * @return Post[]
     */
    public function getWallPosts(User $user, int $lastId = null): Collection
    {
//        $friendsIds = $user->friends()->pluck('id');
        $friendsIds = [];

        $query = Post::query()
            ->with('user')
            ->with('target')
            ->withCount('likes')
            ->withCount('comments')
            ->where(function (Builder $q) use ($user, $friendsIds) {
                $q
                    ->where('user_id', $user->id)
                    ->orWhere('target_id', $user->id);

                if (count($friendsIds) > 0) {
                    $q
                        ->orWhereIn('user_id', $friendsIds)
                        ->orWhereIn('target_id', $friendsIds);
                }
            })
            ->limit(self::DEFAULT_LIMIT)
            ->orderBy('id', 'DESC');

        if ($lastId !== null && $lastId > 0) {
            $query->where('id', '<', $lastId);
        }

        return $query->get();
    }

}