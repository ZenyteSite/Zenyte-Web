<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
class UserCredit extends Model
{
  public $timestamps = false;
  public $table = 'user_credits';
  protected $fillable = [
      'username',
      'credits',
      'total_credits',
  ];

  public static function getCreditAmount($userID, $userName)
  {
      $query = self::where('user_id', $userID)
          ->where('username', $userName)
          ->first();
      if (!$query) {
          return false;
      }
      return $query->credits;
  }

  public static function createNewCredit($userID, $userName)
  {
      $credits = new self;
      $credits->user_id = $userID;
      $credits->username = $userName;
      $credits->credits = 0;
      $credits->total_credits = 0;
      $credits->save();

      return $credits;
  }

}
