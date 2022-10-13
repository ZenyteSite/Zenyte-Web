<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class AdventurersLog extends Model
{
  public $timestamps = false;
  public $table = 'advlog';

  public static function getGameLogs(string $username)
  {
      return AdventurersLog::where('user', $username)->where('type', 'game')->limit('5')->get();
  }
    public static function getPVPLogs(string $username)
    {
        return AdventurersLog::where('user', $username)->where('type', 'pvp')->limit('5')->get();
    }
}
