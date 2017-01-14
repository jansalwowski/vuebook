<?php

namespace App\Http\Controllers\Api\Images;


use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\AvatarRequest;
use App\Http\Requests\CoverRequest;
use App\Models\Photo;
use App\Services\AvatarUnifier;

class CoversController extends ApiController
{

    public function store(CoverRequest $request)
    {
        $file = $request->file('cover')->store('public/covers');
        $path = str_replace('public/', 'storage/', $file);
        $photo = new Photo([
            'path' => $path,
        ]);

        $this->user->addPhoto($photo);
        $this->user->cover = $path;
        $this->user->save();

        return $this->responseSuccess(['cover' => $this->user->cover]);
    }

}