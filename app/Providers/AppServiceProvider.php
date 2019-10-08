<?php

namespace App\Providers;

use App\Models\Language;
use Illuminate\Support\Facades\Config;
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
        Config::set('app.name', setting('websitename'));
        Config::set('localized-routes.supported-locales', Language::orderBy('sort')->get()->pluck('language_key')->toArray());
    }
}
