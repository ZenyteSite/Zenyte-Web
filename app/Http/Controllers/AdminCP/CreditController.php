<?php

namespace App\Http\Controllers\AdminCP;

use App\Helpers\InvisionAPI;
use App\Models\CreditLog;
use App\Models\Store\UserCredit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class CreditController extends Controller
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
        $credits = UserCredit::query();
        if($request->isMethod('post')) {
            $credits = $credits->where('username',$request->input('search'))->get();
        } else {
            $credits = $credits->paginate(20);
        }
        return view('admincp.credits.index',
            [
                'credits' => $credits
            ]);
    }

    public function giveCredits(Request $request)
    {
        if ($request->isMethod('post')) {
            $credits = $request->input('credits');
            $member = $this->forumInstance->loadMember($request->input('username'));
            if (!$member) {
                Session::flash('userNotFound', 'A user could not be found with the username provided');
                return redirect()->back();
            }
            $existingCredit = UserCredit::where('user_id', $member->getId())->first();
            if ($existingCredit == null) {
                $existingCredit = UserCredit::createNewCredit($member->getId(), $request->input('username'));
            }
            if($request->input('creditAction') == 'add') {
                $existingCredit->credits += $credits;
                $existingCredit->total_credits += $credits;
            } else {
                $existingCredit->credits -= $credits;
            }
            $existingCredit->save();

            $log = new CreditLog();
            $log->author = $this->forumInstance->getCachedMember()->getName();
            $log->recipient = $request->input('username');
            $log->credits = ($request->input('creditAction') == 'add') ? $credits : -$credits;
            $log->given_at = Carbon::now();
            $log->save();

            return redirect(route('admincp.credits'));
        }
        return view('admincp.credits.giveCredits');
    }

    public function creditLog(Request $request)
    {
        $logs = CreditLog::query();
        if($request->isMethod('post')) {
            $logs = $logs->where('author', $request->input('search'))->orWhere('recipient', $request->input('search'))->paginate(20);
        } else {
            $logs = $logs->paginate(20);
        }
        return view('admincp.credits.logs',
            [
                'logs' => $logs
            ]);
    }
}