<?php

namespace Bookkeeper\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStore extends FormRequest
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
            'name' => 'required|max:255',
            'tax_administration' => 'max:64',
            'tax_number' => 'max:64',
            'fax' => 'max:64',
            'tel' => 'max:64',
            'email' => 'nullable|email|max:255',
            'address' => 'max:65535',
            'notes' => 'max:65535'
        ];
    }
}
