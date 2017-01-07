<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentsController extends ApiController
{
    public function index(Post $post, Request $request)
    {
        $lastId = $request->get('lastId', null);
        $limit = $request->get('limit', 10);

        $comments = $post
            ->comments()
            ->with('user')
            ->withCount('likes')
            ->orderBy('id')
            ->limit($limit);

        if ($lastId) {
            $comments->where('id', '>', $lastId);
        }

        return $this->responseSuccess([
            'comments' => $comments->get(),
        ]);
    }

    public function store(Request $request, Post $post)
    {
        $message = $request->get('body');
        $comment = $post->comment($message);
        $comment->load('user');

        return $this->responseSuccess([
            'comment' => $comment,
        ]);
    }
}
