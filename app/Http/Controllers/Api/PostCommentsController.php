<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
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

        $transformedComments = $this->transformComments($comments->get());

        return $this->responseSuccess([
            'comments' => $transformedComments,
        ]);
    }

    public function store(Request $request, Post $post)
    {
        $message = $request->get('body');
        $comment = $post->comment($message);
        $comment->load('user');
        $comment->likes_count = 0;
        $comment->wasLiked = false;

        return $this->responseSuccess([
            'comment' => $comment,
        ]);
    }

    private function transformComments(Collection $comments)
    {
        $ids = $comments->pluck('id');

        $likes = $this->user->likes()
            ->whereIn('likeable_id', $ids)
            ->where('likeable_type', 2)
            ->pluck('likeable_id');

        $transformedComments = $comments->map(function($comment) use($likes) {
            $comment->wasLiked = $likes->contains($comment->id);

            return $comment;
        });

        return $transformedComments;
    }
}
