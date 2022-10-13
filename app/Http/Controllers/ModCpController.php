<?php

namespace App\Http\Controllers;

use App\Helpers\InvisionAPI;
use App\Models\ModCP\PunishmentAction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ModCpController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }

    /**
     * Displays our modcp page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $recentPunishments = PunishmentAction::where('mod_name', $this->forumInstance->getCachedMember()->getName())
            ->latest('punished_on')
            ->limit(3)
            ->get();
        return view('modcp.index',
        [
            'recentPunishments' => $recentPunishments
        ]);
    }
}