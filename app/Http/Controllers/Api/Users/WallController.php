<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiController;
use App\Models\Like;
use App\Models\User;
use App\Services\Repositories\PostRepository;
use Auth;
use Illuminate\Database\Eloquent\Collection;
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
            'posts'=> $this->transformPosts($posts),
        ];

        return $this->responseSuccess($data);
    }

    public function show(User $user, Request $request)
    {
        $lastId = (int) $request->get('lastId', null);
        $posts = (new PostRepository())->getUserWallPosts($user, $lastId);

        $data = [
            'posts'=> $this->transformPosts($posts),
        ];

        return $this->responseSuccess($data);
    }

    private function transformPosts(Collection $posts)
    {
        $ids = $posts->pluck('id');

        $likes = $this->user->likes()
            ->whereIn('likeable_id', $ids)
            ->where('likeable_type', 1)
            ->pluck('likeable_id');

        $transformedPosts = $posts->map(function($post) use($likes) {
            $post->wasLiked = $likes->contains($post->id);

            return $post;
        });

        return $transformedPosts;
    }
}
