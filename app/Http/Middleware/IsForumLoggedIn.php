<?php

namespace App\Http\Middleware;

use App\Helpers\InvisionAPI;
use Closure;

class IsForumLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $instance =  InvisionAPI::getInstance();
        if (!$instance->getCachedMember()) {
            return redirect(config('forum.FORUM_LOGIN_LINK'));
        }
        return $next($request);
    }
}
