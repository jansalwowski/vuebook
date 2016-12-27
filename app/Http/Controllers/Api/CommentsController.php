<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentsController extends ApiController
{

    public function show(Comment $comment) : Response
    {
        return $this->responseSuccess($comment);
    }

    public function update(Request $request, Comment $comment) : Response
    {
        $comment->update($request->all());

        return $this->responseSuccess($request);
    }

    public function destroy(Comment $comment) : Response
    {
        $comment->delete();

        return $this->responseSuccess();
    }
}
