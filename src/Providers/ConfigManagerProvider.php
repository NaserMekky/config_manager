<?php

namespace Nasermekky\ConfigManager\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigManagerProvider extends ServiceProvider
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
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'config_manager');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Publishes Files
        $this->publishes([
            __DIR__.'/../Helpers/Helper.php' => app_path('/Helpers/Helper.php'),
        ],'HelperConfig');

        require_once __DIR__."/../Helpers/Helper.php";
    }
}
