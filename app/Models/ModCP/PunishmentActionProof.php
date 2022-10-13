<?php

namespace App\Models\ModCP;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PunishmentActionProof extends Model
{
  public $timestamps = false;

  protected $fillable = [
      'id',
      'action_id',
      'url',
      'notes',
      'staff_member',
      'timestamp',
  ];

}
