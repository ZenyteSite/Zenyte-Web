<?php

namespace App\Providers;

use App\Helpers\Formatter;
use App\Helpers\InvisionAPI;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $forumUser = InvisionAPI::getInstance()->getCachedMember() ?? null;
            view()->share('forumUser', $forumUser);
    }
}
