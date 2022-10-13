<?php

namespace App\Http\Middleware;

use App\Helpers\InvisionAPI;
use Closure;

class IsForumAdmin
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
        $instance = InvisionAPI::getInstance();
        /**
         * The first check is fairly redundant because we should never hit a page that isn't protected by at least IsForumLoggedIn for this middleware
         * However accidents can happen so let's handle them gracefully if they do!
         */
        if (!$instance->getCachedMember() || !$instance->getCachedMember()->isAdmin()) {
            return abort(401);
        }
        return $next($request);
    }
}
