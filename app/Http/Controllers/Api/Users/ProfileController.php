<?php
/**
 * Created by PhpStorm.
 * User: jansalwowski
 * Date: 11.01.2017
 * Time: 01:05
 */

namespace App\Http\Controllers\Api\Users;


use App\Http\Controllers\Api\ApiController;
use App\Models\User;

class ProfileController extends ApiController
{
    public function index(User $user)
    {
        $ownProfile = false;
        $followed = false;
        $user->followingCount = $user->following()->count();
        $user->followersCount = $user->followers()->count();

        if ($this->user instanceof User) {
            $ownProfile = $this->user->is($user);
            $followed = !$ownProfile && $this->user->isFollowing($user);
        }

        return $this->responseSuccess([
            'user' => $user,
            'ownProfile' => $ownProfile,
            'followed' => $followed,
        ]);
    }
}