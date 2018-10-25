<?php

namespace Bookkeeper\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdatePassword extends FormRequest
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
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password'
        ];
    }
}
