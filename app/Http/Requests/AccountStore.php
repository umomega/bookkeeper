<?php

namespace Bookkeeper\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountStore extends FormRequest
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
            'name' => 'required|max:255|unique:accounts,name',
            'default' => 'required|integer',
            'currency' => 'required',
            'balance' => 'required|integer',
            'notes' => 'max:65535'
        ];
    }
}