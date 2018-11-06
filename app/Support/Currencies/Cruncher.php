<?php


namespace Bookkeeper\Support\Currencies;


use Bookkeeper\Finance\Account;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Cruncher {

    /**
     * @var int
     */
    protected $defaultAccount;

    /**
     * Getter for currency helper
     *
     * @return CurrencyHelper
     */
    protected function getCurrencyHelper()
    {
        return resolve('Bookkeeper\Support\Currencies\CurrencyHelper');
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        if(is_null($defaultAccount = get_default_account(true))) {
            $this->defaultAccount = null;
            return;
        }

        $this->defaultAccount = $defaultAccount->getKey();

        $this->getCurrencyHelper()->putAccount($defaultAccount);
    }

    /**
     * Crunches transactions for given transactions
     *
     * @param Collection $transactions
     * @param Carbon $start
     * @param Carbon $end
     * @return array
     */
    public function compileStatisticsFor(Collection $transactions, Carbon $start, Carbon $end)
    {
        if(is_null($this->defaultAccount))
        {
            return false;
        }

        list($statistics, $labels) = $this->getNewBaseForInterval($start, $end);

        $accounts = $transactions->groupBy('account_id');

        foreach ($accounts as $accountId => $transactionsGrouped)
        {
            $rate = $this->getCurrencyHelper()->getRateFor($accountId);

            $statistics = $this->mergeTransactionsWith($transactionsGrouped, $statistics, $rate);
        }

        $summary = $this->generateSummary($statistics, $this->defaultAccount);
        $statistics = $this->normalizeStatistics($statistics, $this->defaultAccount);

        $vatDifference = $this->calculateVATDifference($transactions, $end);

        return array_merge($summary, compact('statistics', 'labels', 'vatDifference'));
    }

    /**
     * Crunches transactions for an account
     *
     * @param Collection $transactions
     * @param Account $account
     * @param Carbon $start
     * @param Carbon $end
     * @return array
     */
    public function compileAccountStatisticsFor(Collection $transactions, Account $account, Carbon $start, Carbon $end)
    {
        list($statistics, $labels) = $this->getNewBaseForInterval($start, $end);

        $statistics = $this->mergeTransactionsWith($transactions, $statistics, 1);

        $summary = $this->generateSummary($statistics, $account->getKey());
        $statistics = $this->normalizeStatistics($statistics, $account->getKey());

        $vatDifference = $this->calculateVATDifference($transactions, $end);

        return array_merge($summary, compact('statistics', 'labels', 'vatDifference'));
    }


    /**
     * Generates base template for statistics with given interval
     *
     * @param Carbon $start
     * @param Carbon $end
     * @return array
     */
    protected function getNewBaseForInterval(Carbon $start, Carbon $end)
    {
        $months = [];
        $labels = [];

        while ($start->lt($end))
        {
            $months[$start->month] = 0;
            $labels[] = uppercase($start->formatLocalized('%b'));
            $start->addMonth();
        }

        return [
            [
                'income'  => $months,
                'income-i'  => $months,
                'expense' => $months,
                'expense-i' => $months,
            ],
            $labels
        ];
    }

    /**
     * Merges statistics with with new transactions
     *
     * @param Collection $transactions
     * @param array $statistics
     * @param float $rate
     * @return array
     */
    protected function mergeTransactionsWith(Collection $transactions, array $statistics, $rate)
    {
        foreach ($transactions as $transaction)
        {
            $value = intval($transaction->total_amount)/$rate;

            if($transaction->received) {
                $statistics[$transaction->type][$transaction->created_at->month] +=  $value;
            }
            $statistics[$transaction->type . '-i'][$transaction->created_at->month] +=  $value;
        }

        return $statistics;
    }

    /**
     * Generates summary for the statistics
     *
     * @param array $statistics
     * @param int $accountId
     * @return array
     */
    protected function generateSummary(array $statistics, $accountId)
    {
        $totalIncome = array_sum($statistics['income']);
        $totalExpense = array_sum($statistics['expense']);
        $profit = $totalIncome - $totalExpense;

        return [
            'total_income'  => currency_string_for(floor($totalIncome), $accountId),
            'total_expense' => currency_string_for(floor($totalExpense), $accountId),
            'total_profit'  => currency_string_for(floor($profit), $accountId)
        ];
    }

    /**
     * Normalizes statistics while turning them into currency strings
     *
     * @param array $statistics
     * @param int $accountId
     * @return array
     */
    protected function normalizeStatistics(array $statistics, $accountId)
    {
        foreach ($statistics as $category => $months)
        {
            foreach ($months as $month => $value)
            {
                $statistics[$category][$month] = currency_float_for(floor($value), $accountId);
            }

            $statistics[$category] = array_values($statistics[$category]);
        }

        return $statistics;
    }

    /**
     * Calculates VAT difference
     *
     * @param Collection $transactions
     * @param Carbon $end
     * @return array
     */
    public function calculateVATDifference(Collection $transactions, Carbon $end)
    {
        $start = $end->copy()->startOfMonth();

        $transactions = $transactions->where('received', 1);

        $transactions = $transactions->filter(function ($transaction) use ($start, $end) {
            return ($transaction->created_at > $start) && ($transaction->created_at < $end);
        });

        $accounts = $transactions->groupBy('account_id');

        $totalTaxDifference = 0;

        foreach ($accounts as $accountId => $transactions)
        {
            $rate = $this->getCurrencyHelper()->getRateFor($accountId);

            $incomeTax = $transactions->where('type', 'income')->sum('vat_amount');
            $expenseTax = $transactions->where('type', 'expense')->sum('vat_amount');

            $totalTaxDifference += ($incomeTax - $expenseTax)/$rate;
        }

        $totalTaxDifference = currency_string_for(floor($totalTaxDifference), $this->defaultAccount);

        return ['vat_difference' => $totalTaxDifference, 'vat_month' => $end->formatLocalized('%B')];
    }

}
