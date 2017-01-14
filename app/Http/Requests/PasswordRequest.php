<?php

namespace App\Http\Requests;

use Hash;
use Illuminate\Foundation\Http\FormRequest;
use Validator;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user('api');

        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) use ($user) {
            return Hash::check($value, $user->password);
        });

        return [
            'old_password' => 'required|current_password',
            'new_password' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'current_password' => 'Provided password is incorrect.'
        ];
    }
}
