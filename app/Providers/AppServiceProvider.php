<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Satu instance pengaturan per request (hindari query berulang).
        $this->app->scoped('site.settings', fn () => SiteSetting::current());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan pengaturan situs ke seluruh view publik.
        View::composer('layouts.public', function ($view) {
            $view->with('settings', app('site.settings'));
        });

        View::composer(['home', 'pages.*', 'catalog.*', 'posts.*'], function ($view) {
            $view->with('settings', app('site.settings'));
        });
    }
}
