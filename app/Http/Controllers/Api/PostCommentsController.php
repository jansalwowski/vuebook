<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentsController extends ApiController
{
    public function index(Post $post)
    {
        $comments = $post->comments;

        return $this->responseSuccess([
            'comments' => $comments,
        ]);
    }

    public function store(Request $request, Post $post)
    {
        $commentData = $request->only([
            'body',
        ]);

        $comment = $post->comment($commentData);

        return $this->responseSuccess([
            'comment' => $comment,
        ]);
    }
}
