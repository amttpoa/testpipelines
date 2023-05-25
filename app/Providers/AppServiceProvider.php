<?php

namespace App\Providers;

use App\Models\Award;
use App\Models\Conference;
use Illuminate\Support\Facades\View;
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
        $activeConferences = Conference::where('conference_visible', 1)->where('end_date', '>', now())->orderBy('start_date')->get();
        $navAwards = Award::orderBy('order')->get();
        // $activeConferences = [];
        // $navAwards = [];
        // Sharing is caring
        View::share('activeConferences', $activeConferences);
        View::share('navAwards', $navAwards);
    }
}
