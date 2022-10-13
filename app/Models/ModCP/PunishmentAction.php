<?php

namespace App\Models\ModCP;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PunishmentAction extends Model
{
  public $timestamps = false;


    public function getProofURLS($proofId)
    {
        $urls = [];
        foreach(Storage::disk('s3')->allFiles(config('modcp.punishment_proof_bucket') . '/' . $this->id . '/' . $proofId) as $file) {
            $urls[] = Storage::disk('s3')->url($file);
        }
        return $urls;
    }
}
