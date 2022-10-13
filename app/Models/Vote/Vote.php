<?php

namespace App\Models\Vote;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vote extends Model
{
    public $timestamps = false;

    public static function getLeaders(string $date)
    {
        return DB::table('votes')
            ->select('username', DB::raw('COUNT(*) AS votecount'))
            ->whereMonth('voted_on',  Carbon::parse($date)->format('m'))
            ->whereYear('voted_on',  Carbon::parse($date)->format('yy'))
            ->groupBy('username')
            ->orderByRaw('votecount DESC LIMIT 10')
            ->get();
    }

    public static function findVoteByKey(string $key)
    {
        return Vote::where('vote_key', $key)->first();
    }
}
