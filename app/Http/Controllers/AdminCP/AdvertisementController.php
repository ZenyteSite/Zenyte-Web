<?php

namespace App\Http\Controllers\AdminCP;

use App\Helpers\InvisionAPI;
use App\Models\AdminCP\AdvertisementSite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdvertisementController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }

    /**
     * Displays our admincp page
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sites = AdvertisementSite::latest('total_clicks');
        if($request->isMethod('post')) {
            $sites = $sites->where('website', 'like', '%' . $request->input('search') . '%');
        }
        return view('admincp.advertisements.index',
            [
                'sites' => $sites->paginate(10)
            ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $advertisementSite = new AdvertisementSite();
            $advertisementSite->website = $request->input('website');
            $advertisementSite->link = $request->input('link');
            $advertisementSite->cost = $request->input('cost');
            $advertisementSite->date_added = Carbon::now();
            $advertisementSite->total_clicks = 0;
            $advertisementSite->unique_clicks = 0;
            $advertisementSite->logins = 0;
            $advertisementSite->save();

            return redirect(route('admincp.advertisements'));
        }
        return view('admincp.advertisements.create');
    }


    public function edit(Request $request, AdvertisementSite $advertisementSite)
    {
        if ($request->isMethod('post')) {
            $advertisementSite->website = $request->input('website');
            $advertisementSite->link = $request->input('link');
            $advertisementSite->cost = $request->input('cost');
            $advertisementSite->save();

            return redirect(route('admincp.advertisements'));
        }
        return view('admincp.advertisements.edit',
            [
                'advertisementSite' => $advertisementSite
            ]);
    }

    public function delete(AdvertisementSite $advertisementSite)
    {
        $advertisementSite->delete();
        return redirect(route('admincp.advertisements'));
    }

}