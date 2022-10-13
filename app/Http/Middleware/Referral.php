<?php

namespace App\Http\Middleware;

use App\Models\AdminCP\AdvertisementSite;
use App\Models\AdminCP\ReferredUser;
use Closure;
use Carbon\Carbon;

class Referral
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('r')) {
            $referralInput = $request->input('r');
            $advertisementSite = AdvertisementSite::where('link', $referralInput)->first();
            if ($advertisementSite) {
                $advertisementSite->total_clicks += 1;
                $visitedIPCheck = ReferredUser::query()->where('referral', $referralInput)->where('ip', $request->ip())->first();
                if ($visitedIPCheck == null) {
                    $advertisementSite->unique_clicks += 1;
                }
                $advertisementSite->save();
                $newReferral = new ReferredUser();
                $newReferral->referral = $referralInput;
                $newReferral->ip = $request->ip();
                $newReferral->logged = 0;
                $newReferral->date = Carbon::now();
                $newReferral->save();
            }
        }
        return $next($request);
    }
}
