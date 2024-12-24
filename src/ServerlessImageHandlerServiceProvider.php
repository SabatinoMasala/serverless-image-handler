<?php

namespace Sabatino\ServerlessImageHandler;

use Illuminate\Support\ServiceProvider;

class ServerlessImageHandlerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/serverless-image-handler.php' => config_path('serverless-image-handler.php'),
        ], 'serverless-image-handler');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/serverless-image-handler.php', 'serverless-image-handler'
        );
    }
}
