<?php

namespace App\Models;

use App\Helpers\InvisionAPI;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CreditPayment extends Model
{
    public $timestamps = false;

    public static function getPaypalPayments()
    {
        return CreditPayment::where('zip_pass', 'paypal');
    }

    public static function getCoinbasePayments()
    {
        return CreditPayment::where('zip_pass', 'coinbase');
    }

    /**
     * Allows us to get all our paypal payments as a sum and provides an optional month too. Use the number of the month e.g. '4'
     * @param null $month
     * @return mixed
     */
    public static function getAllPaypalPaymentsSum($month = null)
    {
        $payments = CreditPayment::getPaypalPayments();
        if ($month) {
            $payments->whereMonth('paid_on', $month);
        }
        return $payments->sum('paid');
    }

    /**
     * Allows us to get all our coinbase payments as a sum and provides an optional month too. Use the number of the month e.g. '4'
     * @param null $month
     * @return mixed
     */
    public static function getAllCoinbasePaymentsSum($month = null)
    {
        $payments = CreditPayment::getCoinbasePayments();
        if ($month) {
            $payments->whereMonth('paid_on', $month);
        }
        return $payments->sum('paid');
    }

    /**
     * Allows us to get all our osrs payments as a sum and provides an optional month too. Use the number of the month e.g. '4'
     * @param null $month
     * @return mixed
     */
    public static function getAllOSRSPaymentsSum($month = null)
    {
        $payments = CreditPayment::getOSRSPayments();
        if ($month) {
            $payments->whereMonth('paid_on', $month);
        }
        return $payments->sum('paid');
    }

    /**
     * Handles how much OSGP we are allowed to process for today
     */
    public static function getRemainingOSGPAllowed($username)
    {
        $paidToday = CreditPayment::getOSRSPayments()
            ->where('cvc_pass', $username)
            ->whereDay('paid_on', Carbon::now()->format('d'))
            ->sum('paid');
        $member = InvisionAPI::getInstance()->loadMember($username);
        $limit = config('modcp.daily_osgp_donation_limits')[$member->getGroupId()];
        return number_format($limit - ($paidToday / config('store.osgp_rate')), 0);
    }

    public static function getOSRSPayments()
    {
        return CreditPayment::whereIn('zip_pass', ['osrs', 'HOLIDAY osrs']);
    }

    /**
     * Takes care of our sale calculations
     * Type should be osgp, crypto or paypal
     * @param $usdAmount
     * @param $type
     * @return float|int
     */
    public static function calculateCreditsAmount($usdAmount, $type)
    {
        if (config('store.sale.' . $type . '.enabled')) {
            return ($usdAmount * 10) + ($usdAmount * config('store.sale.' . $type . '.amount') / 100);
        }
        return $usdAmount * 10;
    }

    public function getTotalDonated($username)
    {
        return self::where('username', $username)->sum('paid');
    }

}
