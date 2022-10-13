<?php

namespace App\Http\Controllers\AdminCP;

use App\Helpers\InvisionAPI;
use App\Models\CreditPayment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PaymentsController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }

    /**
     * Displays our admincp page
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $payments = CreditPayment::latest('paid_on')->where('zip_pass', '!=', 'bond');
        if($request->input('osrs')) {
            $payments = $payments->whereIn('zip_pass', ['osrs', 'HOLIDAY osrs']);
        } elseif($request->input('coinbase')) {
            $payments = $payments->where('zip_pass', 'coinbase');
        } elseif($request->input('paypal')) {
            $payments = $payments->where('zip_pass', 'paypal');
        }
        if($request->isMethod('post')) {
            $payments = $payments->where('username', 'like', '%' . $request->input('search') . '%');
        }
        return view('admincp.payments.index',
            [
                'payments' => $payments->paginate(15)
            ]);
    }
}