<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class UpdateUserRequest extends FormRequest
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
        return [
            'user_realname' => 'required|min:5|max:45',
            'username' => 'required|min:5|max:45|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|max:50',
        ];
    }
}
