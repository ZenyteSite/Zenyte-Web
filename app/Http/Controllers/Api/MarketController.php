<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModCP\TradeLog;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function getData(Request $request)
    {
        if ($request->isMethod('post')) {
            $item = $request->input('itemSearch');
            $result = TradeLog::findRecentTradesByItem($item);
        } else {
            $result = TradeLog::findRecentTrades();
        }

        return response()->json($result, 200);
    }
}