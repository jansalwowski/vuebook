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

class FollowersController extends ApiController
{

    public function index()
    {
        $followersCount = $this->user->followers()->count();
        $followers = $this->user->followers;

        return $this->responseSuccess([
            'followersCount' => $followersCount,
            'followers' => $followers,
        ]);
    }

    public function show(User $user)
    {
        $followersCount = $user->followers()->count();
        $followers = $user->followers;

        return $this->responseSuccess([
            'followersCount' => $followersCount,
            'followers' => $followers,
        ]);
    }
}