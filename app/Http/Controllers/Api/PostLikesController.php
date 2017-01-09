<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Models\ResourceCannotBeLikedTwiceException;
use App\Models\Post;

class PostLikesController extends ApiController
{
    public function index(Post $post)
    {
        $likes = $post->likes;

        return $this->responseSuccess([
            'likes' => $likes,
        ]);
    }

    public function store(Post $post)
    {
        try {
            $post->like();
        } catch (ResourceCannotBeLikedTwiceException $e) {
            return $this->responseInternalError([
                'message' => 'Post cannot be liked by you twice.',
            ]);
        }

        return $this->responseSuccess([
            'liked' => true,
        ]);
    }

    public function destroy(Post $post)
    {
        $post->unlike();

        return $this->responseSuccess([
            'liked' => false,
        ]);
    }
}
