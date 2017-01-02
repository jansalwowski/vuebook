<?php

namespace App\Http\Controllers\Api\Images;


use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\AvatarRequest;
use App\Models\Photo;
use App\Services\AvatarUnifier;

class AvatarsController extends ApiController
{

    public function store(AvatarRequest $request)
    {
        $file = $request->file('avatar')->store('public/avatars');
        $path = str_replace('public/', 'storage/', $file);
        $photo = new Photo([
            'path' => $path,
        ]);

        $this->user->addPhoto($photo);

        return $this->responseSuccess([$this->user->avatar]);
    }

}