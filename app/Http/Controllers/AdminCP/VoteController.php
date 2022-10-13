<?php

namespace App\Http\Controllers\AdminCP;

use App\Helpers\InvisionAPI;
use App\Models\VoteSite;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VoteController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }

    /**
     * Displays our admincp page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admincp.vote.index',
        [
            'sites' => VoteSite::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $voteSite = new VoteSite();
            $voteSite->title = $request->input('title');
            $voteSite->url = $request->input('url');
            $voteSite->visible = $request->input('visible') ?? 0;
            $voteSite->ipAddress = $request->input('ip');
            $voteSite->save();

            return redirect(route('admincp.vote'));
        }
        return view('admincp.vote.create');
    }


    public function edit(Request $request, VoteSite $voteSite)
    {
        if ($request->isMethod('post')) {
            $voteSite->title = $request->input('title');
            $voteSite->url = $request->input('url');
            $voteSite->visible = $request->input('visible') ?? 0;
            $voteSite->ipAddress = $request->input('ip');
            $voteSite->save();

            return redirect(route('admincp.vote'));
        }
        return view('admincp.vote.edit',
        [
            'voteSite' => $voteSite
        ]);
    }

    public function delete(VoteSite $voteSite)
    {
        $voteSite->delete();
        return redirect(route('admincp.vote'));
    }

}