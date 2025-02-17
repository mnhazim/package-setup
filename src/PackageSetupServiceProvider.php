<?php

namespace Mnhazim\PackageSetup;

use Illuminate\Support\ServiceProvider;

class PackageSetupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallCommand::class,
            ]);

        //     // Publish configuration
        //     $this->publishes([
        //         __DIR__.'/../config/package-setup.php' => config_path('package-setup.php'),
        //     ], 'config');

        //     // Publish stubs
        //     $this->publishes([
        //         __DIR__.'/../stubs' => base_path('stubs/package-setup'),
        //     ], 'stubs');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/package-setup.php', 'package-setup'
        );
    }
}
