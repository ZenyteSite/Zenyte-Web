<?php

namespace App\Http\Controllers\Store;

use App\Helpers\InvisionAPI;
use App\Http\Controllers\Controller;
use App\Models\CreditPackage;
use App\Models\CreditPayment;
use App\Models\Product;
use App\Models\Store\UserCredit;
use Illuminate\Http\Request;

class BuyCreditsController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }
    /**
     * Displays our buy credits page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $allowedPaymentMethods = [
            'paypal',
            'crypto'
        ];
        $paymentMethod = $request->input('method') ?? 'paypal';
        if(!in_array($paymentMethod, $allowedPaymentMethods)) {
            abort(404);
        }
        //Seperate functions in checkout controller for payment methods
        $member = $this->forumInstance->getCachedMember();
        $memberName = $member->getName();
        $totalDonated = CreditPayment::where('username', $memberName)->sum('paid');

        return view('store.buyCredits', [
            'packages' => CreditPackage::all(),
            'paymentMethod' => $paymentMethod,
        ]);
    }
}