<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Models\ResourceCannotBeLikedTwiceException;
use App\Models\Comment;

class CommentLikesController extends ApiController
{
    public function index(Comment $comment)
    {
        $likes = $comment->likes;

        return $this->responseSuccess([
            'likes' => $likes,
        ]);
    }

    public function store(Comment $comment)
    {
        try {
            $comment->like();
        } catch (ResourceCannotBeLikedTwiceException $e) {
            return $this->responseInternalError([
                'message' => 'Post cannot be liked by you twice.',
            ]);
        }

        return $this->responseSuccess([
            'liked' => true,
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->unlike();

        return $this->responseSuccess([
            'unliked' => true,
        ]);
    }
}
