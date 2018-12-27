<?php

namespace Bookkeeper\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionStore extends FormRequest
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
            'type' => 'required|in:income,expense',
            'amount' => 'required|integer',
            'vat_percentage' => 'required|numeric',
            'account_id' => 'required',
            'job_id' => 'nullable|integer',
            'created_at' => 'required|date',
            'received_at' => 'required|date',
            'received' => 'required|boolean',
            'excluded' => 'required|boolean',
            'invoice' => 'nullable|file|mimes:jpeg,png,gif,bmp,pdf,doc,docx',
            'notes' => 'max:65535'
        ];
    }
}
