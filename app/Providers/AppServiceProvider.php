<?php

namespace App\Providers;

use App\Contract\AttributesFeature\Handler\ExtractAttributes;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('tag', function ($app) {
            return new \App\Dtos\AttributeContainers((new ExtractAttributes()));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
