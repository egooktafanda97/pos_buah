<?php

namespace Captain\Providers;

use PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider;
use Illuminate\Support\ServiceProvider as ServiceProviders;
use Spatie\Permission\PermissionServiceProvider;

class ServiceProvider extends ServiceProviders
{
    public function boot()
    {
        //        if ($this->app->runningInConsole()) {
        //            $this->commands([
        //                PermissionServiceProvider::class,
        //            ]);
        //        }
        (new \Captain\module\route\Route())->web();
    }

    public function register()
    {
        app()->register(LaravelServiceProvider::class);
        app()->register(PermissionServiceProvider::class);
    }
}
