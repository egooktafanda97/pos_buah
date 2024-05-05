<?php

namespace TaliumAttributes\Provider;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use TaliumAttributes\console\PushControllerList;
use TaliumAttributes\Handler\RouterHandler as HandlerRouterHandler;

class TaliumAttributesServiceProvider extends ServiceProvider
{
    /**
     * Register services.s
     *
     * @return void
     */
    public function register()
    {

        // $this->mergeConfigFrom(base_path("config/config.php"), __DIR__ . './../config/talium_config.php');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        HandlerRouterHandler::route();

        if ($this->app->runningInConsole()) {
            $this->commands([
                PushControllerList::class,
            ]);
        }

        // if ($this->app->runningInConsole()) {
        //     $this->publishes([
        //         __DIR__ . '/../config/config.php' => config_path('route-controllers.php'),
        //     ], 'config');
        // }
    }
}
