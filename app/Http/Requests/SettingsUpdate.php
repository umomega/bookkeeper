<?php

namespace Bookkeeper\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Bookkeeper\Support\Currencies\CurrencyHelper;
use Bookkeeper\Support\Install\InstallHelper;

class SettingsUpdate extends FormRequest
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
            'APP_LOCALE' => 'required|in:' . implode(',', array_keys(InstallHelper::$locales)),
            'DEFAULT_CURRENCY' => 'required|in:' . implode(',', array_keys(CurrencyHelper::getCurrencies()))
        ];
    }
}
