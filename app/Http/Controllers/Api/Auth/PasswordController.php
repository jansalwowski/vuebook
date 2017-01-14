<?php
/**
 * Created by PhpStorm.
 * User: jansalwowski
 * Date: 14.01.2017
 * Time: 14:32
 */

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;

class PasswordController extends ApiController
{

    public function update(PasswordRequest $request)
    {
        $newPassword = $request->get('new_password');
        $revokeToken = $request->get('revokeToken', false);
        $response = [];

        $this->user->setPassword($newPassword);


        if ($revokeToken) {
            $this->user->token()->revoke();

            $accessToken = $this->user->createToken('vuebook')->accessToken;

            $response = [
                'token' => $accessToken,
                'message' => 'Token revoked.'
            ];
        }

        return $this->responseSuccess($response);
    }

}