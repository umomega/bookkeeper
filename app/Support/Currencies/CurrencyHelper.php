<?php


namespace Bookkeeper\Support\Currencies;


use Bookkeeper\Finance\Account;

class CurrencyHelper {

    /** @var string */
    public $base = null;

    /** @var array */
    public static $currencies = [
        'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CNY', 'CZK', 'DKK',
        'EUR', 'GBP', 'HKD', 'HRK', 'HUF', 'IDR', 'ILS', 'INR',
        'JPY', 'KRW', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN',
        'RON', 'RUB', 'SEK', 'SGD', 'THB', 'TRY', 'USD', 'ZAR'
    ];

    /** @var array */
    public static $zeroDecimalCurrencies = ['JPY'];

    /** @var array */
    public static $singleDecimalCurrencies = ['CNY'];

    /** @var Account */
    protected $accounts = [];

    /**
     * Returns a list of currencies
     *
     * @return array
     */
    public static function getCurrencies()
    {
        $currencies = [];

        foreach (static::$currencies as $currency)
        {
            $currencies[$currency] = $currency;
        }

        return $currencies;
    }

    /**
     * Returns the decimal digits for the currency
     *
     * @param string $currency
     * @return int
     */
    public static function getDecimalDigitsFor($currency)
    {
        if (in_array($currency, static::$zeroDecimalCurrencies))
        {
            return 0;
        } elseif (in_array($currency, static::$singleDecimalCurrencies))
        {
            return 1;
        }

        return 2;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->base = config('app.default_currency');
    }

    /**
     * Converts amount to currency text
     *
     * @param int $amount
     * @param int|Account $account
     * @return string
     */
    public function currencyStringFor($amount, $account)
    {
        if ( ! $account instanceof Account) {
            $account = $this->getAccount($account);
        }

        $currency = $account->currency;
        $decimal = static::getDecimalDigitsFor($currency);

        if ($amount == 0)
        {
            return $this->zeroCurrencyFloat($decimal) . ' ' . $currency;
        }

        if ($decimal == 0)
        {
            return $amount . ' ' . $currency;
        }

        return $this->decimalCurrencyFloat($decimal, $amount) . ' ' . $currency;
    }

    /**
     * Converts amount to currency float
     *
     * @param int $amount
     * @param int $accountId
     * @return float
     */
    public function currencyFloatFor($amount, $accountId)
    {
        $account = $this->getAccount($accountId);

        $decimal = static::getDecimalDigitsFor($account->currency);

        if ($amount == 0)
        {
            return $this->zeroCurrencyFloat($decimal);
        }

        if ($decimal == 0)
        {
            return $amount;
        }

        return $this->decimalCurrencyFloat($decimal, $amount);
    }

    /**
     * Gets and caches an account
     *
     * @param int $id
     * @return Account
     */
    protected function getAccount($id)
    {
        if ( ! array_key_exists($id, $this->accounts))
        {
            $account = Account::findOrFail($id);
            $this->accounts[$id] = $account;
        }

        return $this->accounts[$id];
    }

    /**
     * Generates a zero string response
     *
     * @param int $decimal
     * @return string
     */
    protected function zeroCurrencyFloat($decimal)
    {
        if ($decimal == 0)
        {
            return 0;
        } elseif ($decimal == 1)
        {
            return 0.0;
        }

        return 0.00;
    }

    /**
     * Generates a decimal based amount response
     *
     * @param int $decimal
     * @param int $amount
     * @return float
     */
    protected function decimalCurrencyFloat($decimal, $amount)
    {
        if ($decimal == 1) {
            return $amount/10;
        }

        return $amount/100;
    }

}
