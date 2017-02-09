<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends ApiController
{
    public function store(CreatePostRequest $request)
    {
        $postData = $request->only([
            'body',
            'target_id',
            'type',
            'privacy_type',
        ]);
        $post = new Post($postData);

        $this->user->addPost($post);
        $post->load(['user', 'target']);
        $post->comments_count = 0;
        $post->likes_count = 0;
        $post->was_liked = false;

        return $this->responseSuccess(['post' => $post]);
    }

    public function update(Request $request, Post $post) : Response
    {
        $post->update($request->only('body'));

        return $this->responseSuccess(['post' => $post]);
    }

    public function destroy(Post $post) : Response
    {
        $post->delete();

        return $this->responseSuccess();
    }
}
