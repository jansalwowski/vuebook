<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentsController extends ApiController
{
    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->all());

        return $this->responseSuccess([
            'comment' => $comment
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return $this->responseSuccess();
    }
}
