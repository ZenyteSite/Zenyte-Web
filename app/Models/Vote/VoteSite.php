<?php

namespace App\Models\Vote;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
class VoteSite extends Model
{
    public $timestamps = false;

    public function mostRecentVote(string $playerName)
    {
        return Vote::query()
            ->where('site_id', $this->id)
            ->whereNotNull('voted_on')
            ->where('username', $playerName)
            ->latest('voted_on')
            ->first();
    }

    public function getNextAvailableVoteTimeInSeconds(string $previousDate)
    {
        $recentVoteTime = Carbon::parse($previousDate);
        $nextVote = $recentVoteTime->addHours(12);
        return Carbon::now()->diffInSeconds($nextVote);
    }

    public function checkIP(string $ip)
    {
        if ($this->ip !== null) {
            return VoteSite::where('ipAddress', $ip)->count();
        }
        return 1;
    }
}
