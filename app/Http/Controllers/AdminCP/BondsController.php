<?php

namespace App\Http\Controllers\AdminCP;

use App\Helpers\InvisionAPI;
use App\Models\CreditPayment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BondsController extends Controller
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
        $bonds = CreditPayment::latest('paid_on')->where('zip_pass', 'bond');
        if($request->isMethod('post')) {
            $bonds = $bonds->where('username', 'like', '%' . $request->input('search') . '%');
        }
        return view('admincp.bonds.index',
            [
                'bonds' => $bonds->paginate(15)
            ]);
    }
}