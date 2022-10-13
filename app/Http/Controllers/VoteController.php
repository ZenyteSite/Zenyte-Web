<?php

namespace App\Http\Controllers;

use App\Helpers\InvisionAPI;
use App\Models\Vote;
use App\Models\VoteSite;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }

    /**
     * Displays our vote page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sites = VoteSite::all();
        $votesThisMonth = Vote::whereNotNull('voted_on')->whereMonth('voted_on', Carbon::now()->format('m'))->whereYear('voted_on', Carbon::now()->format('yy'))->count();
        $votesAllTime = Vote::whereNotNull('voted_on')->count();
        return view('vote.index', [
            'sites' => $sites,
            'votesThisMonth' => $votesThisMonth,
            'votesAllTime' => $votesAllTime,
            'thisMonthLeaders' => Vote::getLeaders(Carbon::now()),
            'lastMonthLeaders' => Vote::getLeaders(Carbon::now()->subMonth())
        ]);
    }

    public function proceedToVote(VoteSite $site)
    {
        $voteKey = Str::random();
        if (Vote::query()->where('vote_key', $voteKey)->first() != null) { //If we are  using the same vote key as one that already exists in the database
            $voteKey = Str::random(); //Generate a new vote key
        }
        $recentVote = $site->mostRecentVote($this->forumInstance->getCachedMember()->getName());

        if($recentVote > Carbon::now()->subDays(1)->toDateTimeString()) { //If we've voted for this site in the last 24 hours
            $timeLeft = $site->getNextAvailableVoteTimeInSeconds(Carbon::parse($recentVote->voted_on)->toDateTimeString());
            Session::flash('24hourcheck', 'You can vote on ' . $site->title . ' in another ');
            return view('vote.error', [
                'timeLeft' => CarbonInterval::seconds($timeLeft)->cascade()->forHumans(),
            ]);
        }
        $vote = new Vote();
        $vote->user_id = $this->forumInstance->getCachedMember()->getId();
        $vote->username = $this->forumInstance->getCachedMember()->getName();
        $vote->site_id = $site->id;
        $vote->vote_key = $voteKey;
        $vote->started_on = Carbon::now();
        $vote->claimed = 0;
        $vote->save();

        $url = $site->url . $voteKey;
        return Redirect::to($url);
    }

    public function callback(Request $request)
    {
        $response = $request->query->all();
        if (config('vote.require_toplist_ip_in_callback') && (new VoteSite)->checkIP($request->ip()) < 1) {
                return redirect(route('vote'));
        }
        foreach ($response as $parameter => $value) {
            $result = preg_match('/^[a-zA-Z0-9]+$/', $value, $data);

            if ($result === false || $result == 0) {
                continue;
            }
            $voteKey = filter_var($value, FILTER_SANITIZE_STRING);
            $vote = Vote::findVoteByKey($voteKey);

            if($vote) {
                $vote->voted_on = Carbon::now();
                $vote->save();
                break;
            }

        }
    }
}