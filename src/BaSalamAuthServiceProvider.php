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
        $this->mergeConfigFrom(__DIR__ . '/config/basalam_auth.php', 'basalam_auth');
        $this->publishes([__DIR__ . '/config/basalam_auth.php' => config_path("basalam_auth.php")]);
    }
}
