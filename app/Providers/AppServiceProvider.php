<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

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
        // Fetch only first row (assuming single settings record)
        $setting = cache()->remember('global_setting', 60 * 60, function () {
            return Setting::first();
        });

        // Share to all Blade views
        View::share('setting', $setting);
    }
}
