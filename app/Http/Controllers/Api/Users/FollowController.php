<?php
/**
 * Created by PhpStorm.
 * User: jansalwowski
 * Date: 10.01.2017
 * Time: 20:10
 */

namespace App\Http\Controllers\Api\Users;


use App\Http\Controllers\Api\ApiController;
use App\Models\User;

class FollowController extends ApiController
{

    public function store(User $user)
    {
        if ($this->user->is($user)) {
            return $this->responseInternalError([
                'error' => 'You cannot follow yourself'
            ]);
        }

        $this->user->follow($user);

        return $this->responseSuccess([
            'followed' => true,
        ]);
    }

    public function delete(User $user)
    {
        if ($this->user->is($user)) {
            return $this->responseInternalError([
                'error' => 'You cannot unfollow yourself'
            ]);
        }

        $this->user->unfollow($user);

        return $this->responseSuccess([
            'followed' => false,
        ]);
    }

}