<?php

namespace Bookkeeper\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonStore extends FormRequest
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
            'first_name' => 'required|max:64',
            'last_name' => 'max:64',
            'company' => 'max:128',
            'job_title' => 'max:64',
            'nationality' => 'max:32',
            'national_id' => 'max:32',
            'email' => 'nullable|email|max:255',
            'tel' => 'max:64',
            'tel_mobile' => 'max:64',
            'fax' => 'max:64',
            'address' => 'max:256',
            'city' => 'max:64',
            'state' => 'max:64',
            'country' => 'max:64',
            'postal_code' => 'max:16',
            'notes' => 'max:65535'
        ];
    }
}
