<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Services\Repositories\PostRepository;
use Auth;
use Illuminate\Http\Request;

class WallController extends ApiController
{

    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $lastId = (int) $request->get('lastId', null);
        $posts = (new PostRepository())->getMainWallPosts($user, $lastId);

        $data = [
            'posts'=> $posts,
        ];

        return $this->responseSuccess($data);
    }

    public function show(User $user, Request $request)
    {
        $lastId = (int) $request->get('lastId', null);
        $posts = (new PostRepository())->getUserWallPosts($user, $lastId);

        $data = [
            'posts'=> $posts,
        ];

        return $this->responseSuccess($data);
    }
}
