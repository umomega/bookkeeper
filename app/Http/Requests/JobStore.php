<?php

namespace Bookkeeper\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobStore extends FormRequest
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
            'notes' => 'max:65535',
            'offer' => 'nullable|file|mimes:jpeg,png,gif,bmp,pdf,doc,docx',
            'client_id' => 'required|integer'
        ];
    }
}
