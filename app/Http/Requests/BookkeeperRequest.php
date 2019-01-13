<?php

namespace Bookkeeper\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BookkeeperRequest extends FormRequest
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
     * Compiles rules for a given config key
     *
     * @param string
     * @return array
     */
    protected function compileRulesFor($key)
    {
        $rules = [];
        $config = config('forms.' . $key);

        foreach($config as $field => $params)
        {
            if(!array_key_exists($params['rules'])) continue;

            $fieldRules = $params['rules'];

            if(preg_match('/\[\!ROUTE>(.*?)\!\]/', $fieldRules, $o))
            {
                $fieldRules = preg_replace('/\[\!ROUTE>(.*?)\!\]/', $this->route($o[1]), $fieldRules);
            }

            if(preg_match('/\[\!AUTH\!\]/', $fieldRules, $o))
            {
                $fieldRules = preg_replace('/\[\!AUTH\!\]/', auth()->user()->getKey(), $fieldRules);
            }

            $rules[$field] = $fieldRules;
        }

        return $rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->compileRulesFor($this->configKey);
    }

}
