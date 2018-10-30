<?php

if ( ! function_exists('is_installed'))
{
    /**
     * Checks if Bookkeeper is installed
     *
     * @return bool
     */
    function is_installed()
    {
        return (config('app.status', 'INSTALLED') === 'INSTALLED');
    }
}

if ( ! function_exists('is_request_install'))
{
    /**
     * Checks if the request is a install request
     *
     * @return bool
     */
    function is_request_install()
    {
        return (request()->segment(1) === 'install');
    }
}

if ( ! function_exists('bookkeeper_version'))
{
    /**
     * Returns the current bookkeeper version
     *
     * @return int
     */
    function bookkeeper_version()
    {
        return Bookkeeper\Providers\AppServiceProvider::VERSION;
    }
}

if ( ! function_exists('uppercase'))
{
    /**
     * Converts string to uppercase depending on the language
     * This helper mainly resolves the issue for Turkish i => İ
     * This should otherwise be done with CSS
     *
     * @param string $string
     * @param string $locale
     * @return string
     */
    function uppercase($string, $locale = null)
    {
        $locale = $locale ?: App::getLocale();

        if ($locale === 'tr')
        {
            return mb_strtoupper(str_replace('i', 'İ', $string), 'UTF-8');
        }

        return mb_strtoupper($string, 'UTF-8');
    }
}

if ( ! function_exists('get_default_account'))
{
    /**
     * Returns the default account
     *
     * @return bool
     */
    function get_default_account()
    {
        return env('DEFAULT_ACCOUNT');
    }
}

if ( ! function_exists('get_full_locale_for'))
{
    /**
     * Returns the locale count of the app
     *
     * @param string $locale
     * @param bool $trim
     * @return string
     */
    function get_full_locale_for($locale, $trim = false)
    {
        $locale = config('app.full_locales.' . $locale);

        return $trim ? rtrim($locale, '.UTF-8') : $locale;
    }
}

if ( ! function_exists('currency_string_for'))
{
    /**
     * Returns the amount with currency presentation
     *
     * @param int $amount
     * @param int|Account $account
     * @return string
     */
    function currency_string_for($amount, $account)
    {
        return resolve('Bookkeeper\Support\Currencies\CurrencyHelper')
            ->currencyStringFor($amount, $account);
    }
}

if ( ! function_exists('currency_float_for'))
{
    /**
     * Returns the amount with float presentation
     *
     * @param int $amount
     * @param int $accountId
     * @return string
     */
    function currency_float_for($amount, $accountId)
    {
        return resolve('Bookkeeper\Support\Currencies\CurrencyHelper')
            ->currencyFloatFor($amount, $accountId);
    }
}
