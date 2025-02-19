<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    //
    public function boot()
    {
        Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('ip', request()->ip());
            $activity->properties = $activity->properties->put('user_agent', request()->userAgent());
        });
    }
}
