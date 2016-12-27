<?php
//@formatter:off
declare(strict_types = 1);
//@formatter:on


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

class AuthController extends ApiController
{

    public function index(Request $request)
    {
        return $request->user();
    }

}