<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        Artisan::call('migrate');

        Config::set('app.name', setting('websitename'));
        Config::set('localized-routes.supported-locales', Language::orderBy('sort')->get()->pluck('language_key')->toArray());

        View::share('menu_items', Page::where(['parent_id' => '0', 'show_in_menu' => 1])->orderBy('sort')->get());
    }
}
