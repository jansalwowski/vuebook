<?php
namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;

class UsersController extends ApiController
{
    public function show(User $user)
    {
        return $this->responseSuccess(['user' => $user]);
    }
}
