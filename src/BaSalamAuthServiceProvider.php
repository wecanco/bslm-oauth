<?php

namespace BaSalam\Auth;

use Illuminate\Support\ServiceProvider;

class BaSalamAuthServiceProvider extends ServiceProvider
{
    /**
 * Register any application services.
 */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/ba_salam_auth.php', 'ba_salam_auth');
        $this->publishes([__DIR__ . '/config/ba_salam_auth.php' => config_path("ba_salam_auth.php")]);
    }
}
