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
        $followingCount = $this->user->following()->count();
        $following = $this->user->following;

        return $this->responseSuccess([
            'followingCount' => $followingCount,
            'following' => $following,
        ]);
    }

    public function show(User $user)
    {
        $followingCount = $user->following()->count();
        $following = $user->following;

        return $this->responseSuccess([
            'followingCount' => $followingCount,
            'following' => $following,
        ]);
    }
}