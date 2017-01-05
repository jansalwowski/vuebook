<?php
/**
 * Created by PhpStorm.
 * User: jansalwowski
 * Date: 02.01.2017
 * Time: 21:45
 */

namespace App\Http\Controllers\Api\Users;


use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Illuminate\Http\Request;

class UsersSearchController extends ApiController
{

    public function index(Request $request)
    {
        $term = $request->get('term');
        $users = User::where('username', 'LIKE', '%' . $term . '%')->get();

        return $this->responseSuccess($users->toArray());
    }

}