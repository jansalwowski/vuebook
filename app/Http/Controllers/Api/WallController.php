<?php

namespace App\Http\Controllers\Api;

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
        $posts = (new PostRepository())->getWallPosts($user, $lastId);

        $data = [
            'posts'=> $posts,
        ];

        return $this->responseSuccess($data);
    }
}
