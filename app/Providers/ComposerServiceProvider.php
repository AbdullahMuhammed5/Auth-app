<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (count(request()->segments()) > 0){
            View::share('route', request()->segments()[0]);
        }
//        dd(request()->user());
//        View::share('userHasRoles', count(request()->user()->getRoleNames()));

//        View::composer('dashboard', 'App\Composers\DashboardComposer@compose');
    }
}
