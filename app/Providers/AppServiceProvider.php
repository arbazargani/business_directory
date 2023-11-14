<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Session::put('locale', 'fa');
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            App::setLocale('fa');
        }

        if (env('APP_ENV') == 'production') {
            \URL::forceScheme('https');
        }

        if (env('APP_ENV') != 'build') {
            view()->share([
                'currentLocale' => App::currentLocale(),
                'settings' => Cache::remember('site_settings', 60*60*24, function () {
                    return Setting::all();
                }),
            ]);
        }
    }
}
