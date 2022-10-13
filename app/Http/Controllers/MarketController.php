<?php

namespace App\Http\Controllers;

use App\Models\ModCP\TradeLog;
use Illuminate\Routing\Controller;

class MarketController extends Controller
{
    /**
     * Displays our account page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tradeLogs = TradeLog::findRecentTrades();
        return view('market.index', [
            'tradeLogs' => $tradeLogs,
        ]);
    }
}