<?php
/**
 * Created by PhpStorm.
 * User: jansalwowski
 * Date: 03.01.2017
 * Time: 14:08
 */

namespace App\Http\Controllers\Api\Images;


use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class CropController extends ApiController
{

    public function store(Request $request)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');


        }
    }
    
}