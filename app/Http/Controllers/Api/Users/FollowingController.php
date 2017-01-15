<?php
/**
 * Created by PhpStorm.
 * User: jansalwowski
 * Date: 10.01.2017
 * Time: 21:12
 */

namespace App\Http\Controllers\Api\Users;


use App\Http\Controllers\Api\ApiController;
use App\Models\User;

class FollowingController extends ApiController
{

    public function index()
    {
        return $this->show($this->user);
    }

    public function show(User $user)
    {
        $followingCount = $user->following()->count();
        $following = $user->following()
            ->select([
                'users.id', 'users.name', 'users.username', 'users.avatar'
            ])
            ->get();


        if ($this->user instanceof User) {
            $followingIds = $following->pluck('id');

            $authUsersFollows = $this->user
                ->following()
                ->whereIn('users.id', $followingIds)
                ->select('users.id')
                ->get();
        } else {
            $authUsersFollows = collect([]);
        }

        $following = $following->map(function(User $f) use($authUsersFollows) {
            $f->isFollowed = $authUsersFollows->contains($f->id);

            return $f;
        });

        return $this->responseSuccess([
            'followingCount' => $followingCount,
            'following' => $following,
        ]);
    }
}