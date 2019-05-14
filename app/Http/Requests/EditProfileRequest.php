<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Auth;

class EditProfileRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|max:255',
            'email'                 => 'required|email|unique:users,email,'.Auth::user()->id,
            'password'              => 'required|between:8,20|confirmed',
            'password_confirmation' => 'between:8,20'
        ];
    }
}
