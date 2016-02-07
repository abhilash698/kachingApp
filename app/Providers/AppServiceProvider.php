<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*$share['headTags'] = Tag::all();
        view()->share($share);*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
