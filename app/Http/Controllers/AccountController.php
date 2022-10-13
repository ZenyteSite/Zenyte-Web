<?php

namespace App\Http\Controllers;

use App\Helpers\InvisionAPI;
use App\Models\AdventurersLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AccountController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }

    /**
     * Displays our account page
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null $username
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, string $username = null)
    {
        if ($request->isMethod('post')) {
            $username = $request->input('username');
            $user = $this->forumInstance->loadMember($username);
            if ($user === null) {
                return view('account.error');
            }
        }
        if ($username === null) {
            $username = $this->forumInstance->getCachedMember()->getName();
        }
        $user = $this->forumInstance->loadMember($username);
        if ($user === null) {
            return view('account.error');
        }
        $awards = $this->forumInstance->getUserAwards($user->getId());
        $gameLogs = AdventurersLog::getGameLogs($username);
        $pvpLogs = AdventurersLog::getPVPLogs($username);
        return view('account.index',
        [
            'player' => $user,
            'gameLogs' => $gameLogs,
            'pvpLogs' => $pvpLogs,
            'awards' => $awards,
            'isSameUser' => $user->getId() == $this->forumInstance->getCachedMember()->getId(),
        ]);
    }
}