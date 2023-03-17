<?php

namespace FaceDigital\FaceGen\Providers;

use FaceDigital\FaceGen\Commands\FactoryCommand;
use FaceDigital\FaceGen\Commands\MigrationCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FaceGenServiceProvider extends ServiceProvider implements DeferrableProvider
{
    protected const ROOT_PATH = __DIR__. '/../../';

    public function boot()
    {
        $this->publishes([
            self::ROOT_PATH.'/config/facegen.php' => config_path('facegen.php'),
        ], 'facegen');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::ROOT_PATH.'/config/facegen.php',
            'facegen'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrationCommand::class,
                FactoryCommand::class
            ]);
        }
    }

    public function provides()
    {
        return [
            MigrationCommand::class,
            FactoryCommand::class
        ];
    }
}
