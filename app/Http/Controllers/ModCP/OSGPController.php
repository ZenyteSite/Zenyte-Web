<?php

namespace App\Http\Controllers\ModCP;

use App\Helpers\Discord;
use App\Helpers\InvisionAPI;
use App\Models\CreditPayment;
use App\Models\Store\UserCredit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $username = $this->forumInstance->getCachedMember()->getName();
        $osgpLogs = CreditPayment::getOSRSPayments()->where('cvc_pass', $username);
        if ($request->isMethod('post')) { //If we're searching
            $osgpLogs->where('username', $request->input('username'));
        }
        return view('modcp.osgp.index', [
            'osgpLogs' => $osgpLogs->paginate(20),
            'remaining' => CreditPayment::getRemainingOSGPAllowed($username),
        ]);
    }

    public function submitOSGP(Request $request)
    {
        $authorUsername = $this->forumInstance->getCachedMember()->getName();
        $username = $request->input('osgp_username');
        $amount = $request->input('osgp_amount');
        if (CreditPayment::getRemainingOSGPAllowed($authorUsername) < $amount) {
            Session::flash('error', 'You do not have the daily gp allowance available to process this transaction! Please speak to a senior member of staff to have them assist you with this transaction.');
            return redirect()->back();
        }
        $gpAmount = $amount . 'M';
        $usdAmount = $amount * config('store.osgp_rate');
        $creditAmount = CreditPayment::calculateCreditsAmount($usdAmount, 'osgp');
        $userProfile = $this->forumInstance->loadMember($username);
        if ($userProfile === null) {
            Session::flash('error', 'That username does not seem to belong to a registered member. If you think this is a mistake, please speak to a senior member of staff to have them assist you with this transaction.');
            return redirect()->back();
        }

        $osgpDonation = new CreditPayment();
        $osgpDonation->username = $username;
        $osgpDonation->email = $userProfile->getEmail() ?? 'osrs@zenyte.com';
        $osgpDonation->item_name = $gpAmount;
        $osgpDonation->paid = $usdAmount;
        $osgpDonation->credit_amount = $creditAmount;
        $osgpDonation->status = "Completed";
        $osgpDonation->client_ip = $request->ip();
        $osgpDonation->cvc_pass = $authorUsername;
        $osgpDonation->zip_pass = (config('store.sale.osgp.enabled')) ? 'Holiday osrs' : 'osrs';
        $osgpDonation->address_pass = 'mod';
        $osgpDonation->live_mode = 1;
        $osgpDonation->paid_on = Carbon::now();
        $osgpDonation->save();
        Discord::sendOSGPWebhook($authorUsername, $username, $gpAmount, $usdAmount, $creditAmount);

        $credits = UserCredit::where('username', $username)->first();
        if ($credits === null) {
            $credits = UserCredit::createNewCredit($this->forumInstance->loadMember($username)->getId(), $username);
        }
        $credits->credits += $creditAmount;
        $credits->total_credits += $creditAmount;
        $credits->save();
        if($request->input('fromAdmin')) {
            return redirect(route('admincp.osgp'));
        }
        return redirect(route('modcp.osgp'));
    }

}