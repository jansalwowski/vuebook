<?php
/**
 * Created by PhpStorm.
 * User: jansalwowski
 * Date: 31.12.2016
 * Time: 08:56
 */

namespace App\Services;


use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class AvatarUnifier
{

    public function generate(UploadedFile $file)
    {
        $source = $file->getRealPath();
        $image = Image::make($source);
        $image->fit(300, 200);

        return $image;
    }
}