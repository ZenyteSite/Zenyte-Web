<?php

namespace App\Http\Controllers\AdminCP;

use App\Helpers\InvisionAPI;
use App\Models\CreditPayment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OSGPController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }

    /**
     * Displays our osgp page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $username = $this->forumInstance->getCachedMember()->getName();
        $osgpLogs = CreditPayment::getOSRSPayments();
        if ($request->isMethod('post')) { //If we're searching
            if($request->input('search') != null) {
                $osgpLogs = $osgpLogs->where('username', $request->input('search'));
            }
        }
        return view('admincp.osgp.index', [
            'osgpLogs' => $osgpLogs->paginate(20),
            'remaining' => CreditPayment::getRemainingOSGPAllowed($username),
        ]);
    }
}