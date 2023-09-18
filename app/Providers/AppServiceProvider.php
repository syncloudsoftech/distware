<?php

namespace App\Providers;

use App\Models\License;
use App\Models\Plan;
use App\Models\Update;
use App\Models\User;
use App\Observers\LicenseObserver;
use App\Observers\PlanObserver;
use App\Observers\UpdateObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        License::observe(LicenseObserver::class);
        Plan::observe(PlanObserver::class);
        Update::observe(UpdateObserver::class);
        User::observe(UserObserver::class);
    }
}
