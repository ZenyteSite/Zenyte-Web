<?php

namespace App\Http\Controllers;

use App\Helpers\InvisionAPI;
use App\Models\CreditPayment;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class AdminCpController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }
    public function getMostUsedCurrenciesChartThisMonth()
    {
        $mostUsedCurrenciesThisMonthChartOptions = [
            'chart_title' => 'Most Used Currencies This Month',
            'chart_type' => 'pie',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\CreditPayment',
            'group_by_field' => 'zip_pass',
            'filter_field' => 'paid_on',
            'filter_period' => 'month',

        ];
        return new LaravelChart($mostUsedCurrenciesThisMonthChartOptions);
    }
    public function getMostUsedCurrenciesChartLastThreeMonths()
    {
        $mostUsedCurrenciesLastThreeMonthsChartOptions = [
            'chart_title' => 'Most Used Currencies Last Three Months',
            'chart_type' => 'pie',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\CreditPayment',
            'group_by_field' => 'zip_pass',
            'filter_field' => 'paid_on',
            'filter_days' => '90',

        ];
        return new LaravelChart($mostUsedCurrenciesLastThreeMonthsChartOptions);
    }
    public function getMostUsedCurrenciesChartAllTime()
    {
        $mostUsedCurrenciesChartOptions = [
            'chart_title' => 'Most Used Currencies',
            'chart_type' => 'pie',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\CreditPayment',
            'group_by_field' => 'zip_pass',

        ];
        return new LaravelChart($mostUsedCurrenciesChartOptions);
    }
    public function getAllPaymentsOverTimeMonth()
    {
        $getAllPaymentsOverTimeConditions = [
            ['name' => 'OSGP', 'condition' => 'zip_pass = "osrs"', 'color' => 'rgb(54, 162, 235)'],
            ['name' => 'Holiday OSGP', 'condition' => 'zip_pass = "HOLIDAY osrs"', 'color' => 'rgb(54, 162, 235)'],
            ['name' => 'Crypto', 'condition' => 'zip_pass = "coinbase"', 'color' => 'rgb(255, 205, 86)'],
        ];
        if($this->forumInstance->getCachedMember()->isOwner()) {
            $getAllPaymentsOverTimeConditions[] = ['name' => 'PayPal', 'condition' => 'zip_pass = "paypal"', 'color' => 'rgb(255, 99, 132)'];
        }
        $getAllPaymentsOverTimeOptions = [
            'chart_title' => 'All Time Transactions',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\CreditPayment',
            'conditions' => $getAllPaymentsOverTimeConditions,
            'group_by_field' => 'paid_on',
            'group_by_period' => 'month',

            'aggregate_function' => 'sum',
            'aggregate_field' => 'paid',

        ];
        return new LaravelChart($getAllPaymentsOverTimeOptions);
    }
    public function getThisMonthChartPayments()
    {
        $thisMonthChartConditions = [
            ['name' => 'OSGP', 'condition' => 'zip_pass = "osrs"', 'color' => 'rgb(54, 162, 235)'],
            ['name' => 'Holiday OSGP', 'condition' => 'zip_pass = "HOLIDAY osrs"', 'color' => 'rgb(54, 162, 235)'],
            ['name' => 'Crypto', 'condition' => 'zip_pass = "coinbase"', 'color' => 'rgb(255, 205, 86)'],
        ];
        if($this->forumInstance->getCachedMember()->isOwner()) {
            $thisMonthChartConditions[] = ['name' => 'PayPal', 'condition' => 'zip_pass = "paypal"', 'color' => 'rgb(255, 99, 132)'];
        }
        $thisMonthChartOptions = [
            'chart_title' => 'This Months Transactions',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\CreditPayment',
            'conditions' => $thisMonthChartConditions,
            'group_by_field' => 'paid_on',
            'group_by_period' => 'day',
            'filter_field' => 'paid_on',
            'filter_period' => 'month',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'paid',

        ];
        return new LaravelChart($thisMonthChartOptions);
    }
    public function getlast30DaysChartPayments()
    {
        $thirtyDayChartConditions = [
            ['name' => 'OSGP', 'condition' => 'zip_pass = "osrs"', 'color' => 'rgb(54, 162, 235)'],
            ['name' => 'Holiday OSGP', 'condition' => 'zip_pass = "HOLIDAY osrs"', 'color' => 'rgb(54, 162, 235)'],
                ['name' => 'Crypto', 'condition' => 'zip_pass = "coinbase"', 'color' => 'rgb(255, 205, 86)'],
        ];
        if($this->forumInstance->getCachedMember()->isOwner()) {
            $thirtyDayChartConditions[] = ['name' => 'PayPal', 'condition' => 'zip_pass = "paypal"', 'color' => 'rgb(255, 99, 132)'];
        }
        $thirtyDayChartOptions = [
            'chart_title' => 'Last 30 Days Transactions',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\CreditPayment',
            'conditions' => $thirtyDayChartConditions,
            'group_by_field' => 'paid_on',
            'group_by_period' => 'day',

            'aggregate_function' => 'sum',
            'aggregate_field' => 'paid',


            'filter_field' => 'paid_on',
            'filter_days' => 30, // show only transactions for last 30 days
            'filter_period' => 'month', // show only transactions for this week
            'continuous_time' => true, // show continuous timeline including dates without data
        ];
        return new LaravelChart($thirtyDayChartOptions);
    }

    public function getAllVotesOverTimeMonth()
    {
        $getAllVotesOverTimeOptions = [
            'chart_title' => 'All Time Votes',
            'chart_type' => 'bar',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Vote',
            'group_by_field' => 'voted_on',
            'group_by_period' => 'month',

        ];
        return new LaravelChart($getAllVotesOverTimeOptions);
    }
    public function getThisMonthChartVotes()
    {
        $thisMonthChartOptions = [
            'chart_title' => 'This Months Votes',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Vote',
            'group_by_field' => 'voted_on',
            'group_by_period' => 'day',
            'filter_field' => 'voted_on',
            'filter_period' => 'month',

        ];
        return new LaravelChart($thisMonthChartOptions);
    }
    public function getlast30DaysChartVotes()
    {
        $thirtyDayChartOptions = [
            'chart_title' => 'Last 30 Days Votes',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Vote',
            'group_by_field' => 'voted_on',
            'group_by_period' => 'day',


            'filter_field' => 'voted_on',
            'filter_days' => 30, // show only votes for last 30 days
            'filter_period' => 'month', // show only votes for this week
            'continuous_time' => true, // show continuous timeline including dates without data
        ];
        return new LaravelChart($thirtyDayChartOptions);
    }



    /**
     * Displays our admincp page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $thisMonth = Carbon::now()->format('m');
        return view('admincp.index',
            [
                'totalOSGPThisMonth' => CreditPayment::getAllOSRSPaymentsSum($thisMonth),
                'totalOSGP' => CreditPayment::getAllOSRSPaymentsSum(),
                'totalPaypalThisMonth' => CreditPayment::getAllPaypalPaymentsSum($thisMonth),
                'totalPaypal' => CreditPayment::getAllPaypalPaymentsSum(),
                'totalCoinbaseThisMonth' => CreditPayment::getAllCoinbasePaymentsSum($thisMonth),
                'totalCoinbase' => CreditPayment::getAllCoinbasePaymentsSum(),
                'totalVotesThisMonth' => Vote::whereMonth('voted_on', $thisMonth)->count(),
                'totalVotesAllTime' => Vote::count(),
                'last30DaysChart' => $this->getlast30DaysChartPayments(),
                'thisMonthChart' => $this->getThisMonthChartPayments(),
                'mostUsedCurrencies' => $this->getMostUsedCurrenciesChartAllTime(),
                'allPaymentsOverTime' => $this->getAllPaymentsOverTimeMonth(),
                'mostUsedCurrenciesThisMonth' => $this->getMostUsedCurrenciesChartThisMonth(),
                'mostUsedCurrenciesThreeMonth' => $this->getMostUsedCurrenciesChartLastThreeMonths(),
                'allVotesOverTime' => $this->getAllVotesOverTimeMonth(),
                'last30DaysVotes' => $this->getlast30DaysChartVotes(),
                'thisMonthVotes' => $this->getThisMonthChartVotes(),
            ]);
    }

    public function refreshCache()
    {
        Artisan::call('cache:clear');
        Session::flash('success', 'Successfully refreshed the cache');
        return redirect(route('admincp'));
    }
}