<?php
//@formatter:off
declare(strict_types = 1);
//@formatter:on


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Auth;

class RegistrationController extends ApiController
{
    public function store(RegistrationRequest $request)
    {
        $user = $this->create($request->all());

        if(true !== Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]))
        {
            $user->forceDelete();
        }

        $accessToken = $user->createToken('vuebook')->accessToken;

        $data = [
            'access_token' => $accessToken,
            'message' => 'Registration Successful!',
            'user' => $user,
        ];

        return response()->json($data, 200);
    }

    protected function create(array $data)
    {
        $user = User::register([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'birthday' => '1994.10.27'
        ]);

        return $user;
    }
}
