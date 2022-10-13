<?php

namespace App\Models\ModCP;

use App\Helpers\Formatter;
use Illuminate\Database\Eloquent\Model;
class TradeLog extends Model
{
  public $timestamps = false;
  public $table = 'logs_trades';

  public static function findRecentTrades()
  {
      return TradeLog::where('given', '!=', '[]')
          ->where('received', '!=', '[]')
          ->latest('time_added')
          ->limit(20)
          ->get();
  }

    public static function findRecentTradesByItem($itemName)
    {
        return TradeLog::where('given', '!=', '[]')
            ->where('received', '!=', '[]')
            ->where('given', 'like', '%' . $itemName . '%')
            ->orWhere('received', 'like', '%' . $itemName . '%')
            ->latest('time_added')
            ->limit(20)
            ->get();
    }
    /*
     * We use this function because for some reason Laravel doesn't let us pass variables to custom blade directives....
     * Thank you Taylor Otwell
     */
    public static function formatAmount($amount)
    {
        return Formatter::formatRsAmount($amount);
    }
}
