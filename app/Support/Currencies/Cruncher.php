<?php


namespace Bookkeeper\Support\Currencies;


use Bookkeeper\Finance\Account;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
     * @param array $params
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return array
     */
    public function compileStatisticsFor(array $params, Carbon $start = null, Carbon $end = null)
    {
        if(is_null($this->defaultAccount)) return false;

        list($start, $end) = $this->validateStartAndEndDates($start, $end);

        // Get the transactions before the start value has been modified by the base intervals func
        list($transactions, $transactionsVAT) = $this->retrieveTransactions($params, $start, $end);

        list($statistics, $labels) = $this->getNewBaseForInterval($start, $end);

        list($statistics, $summary) = $this->calculateMonthlySums($params, $statistics, $transactions);

        $vatDifference = $this->calculateVATDifference($transactionsVAT, $end);

        return array_merge($summary, compact('statistics', 'labels', 'vatDifference'));
    }

    /**
     * Calculates monthly sums
     *
     * @param array $params
     * @param array $statistics
     * @param Collection $transactions
     * @return array
     */
    protected function calculateMonthlySums(array $params, array $statistics, Collection $transactions)
    {
        if($params['filter'] == 'account')
        {
            $statistics = $this->mergeTransactionsWith($transactions, $statistics, 1);

            $summary = $this->generateSummary($statistics, $params['id']);
            $statistics = $this->normalizeStatistics($statistics, $params['id']);
        } else {
            // Need to group by account id
            $accounts = $transactions->groupBy('account_id');

            foreach ($accounts as $accountId => $transactionsGrouped)
            {
                $rate = $this->getCurrencyHelper()->getRateFor($accountId);

                $statistics = $this->mergeTransactionsWith($transactionsGrouped, $statistics, $rate);
            }

            $summary = $this->generateSummary($statistics, $this->defaultAccount);
            $statistics = $this->normalizeStatistics($statistics, $this->defaultAccount);
        }

        return [$statistics, $summary];
    }

    /**
     * Retrieves transactions for given time period and filters
     *
     * @param array $params
     * @param Carbon $start
     * @param Carbon $end
     * @return array
     */
    protected function retrieveTransactions(array $params, Carbon $start, Carbon $end)
    {
        $startMonth = $end->copy()->startOfMonth();

        if($params['filter'] == 'account')
        {
            $query =  DB::table('transactions')->whereExcluded(0)
                ->where('account_id', $params['id']);
        }
        elseif ($params['filter'] == 'tag')
        {
            $query = DB::table('transactions')->whereExcluded(0)
                ->join('tag_transaction', 'transactions.id', 'tag_transaction.transaction_id')
                ->where('tag_transaction.tag_id', $params['id']);
        }
        else
        {
            $query = DB::table('transactions')->whereExcluded(0);
        }

        return [
            $query->whereBetween('received_at', [$start, $end])->get(),
            $query->whereBetween('created_at', [$startMonth, $end])->get()
        ];
    }

    /**
     * Validates start and end dates
     *
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return array
     */
    protected function validateStartAndEndDates(Carbon $start = null, Carbon $end = null)
    {
        $end = $end ?: Carbon::now()->endOfMonth();
        $start = $start ?: $end->copy()->subYear()->addSecond();

        return [$start, $end];
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
                $statistics[$transaction->type][date_parse($transaction->received_at)['month']] +=  $value;
            }
            $statistics[$transaction->type . '-i'][date_parse($transaction->received_at)['month']] +=  $value;
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
