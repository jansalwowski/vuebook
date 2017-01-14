<?php
//@formatter:off
declare(strict_types = 1);
//@formatter:on


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class CurrentUserController extends ApiController
{

    public function index(Request $request)
    {
        return $request->user();
    }

}