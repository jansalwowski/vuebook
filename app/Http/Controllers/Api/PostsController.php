<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends ApiController
{

    public function index()
    {
        $posts = Post::with('user')->limit(15)->get();

        return $this->responseSuccess([
            'posts' => $posts,
        ]);
    }

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

        return $this->responseSuccess(['past' => $post]);
    }

    public function show(Post $post)
    {
        return $this->responseSuccess(['post' => $post]);
    }

    public function update(Request $request, Post $post) : Response
    {
        $post->update($request->all());

        return $this->responseSuccess(['past' => $post]);
    }

    public function destroy(Post $post) : Response
    {
        $post->delete();

        return $this->responseSuccess();
    }
}
