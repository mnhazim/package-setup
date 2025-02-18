<?php

namespace Mnhazim\PackageSetup;

use Illuminate\Support\ServiceProvider;

class PackageSetupServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            Commands\InstallCommand::class,
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../config/package-setup.php', 'package-setup'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/package-setup.php' => config_path('package-setup.php'),
        ], 'package-setup-config');
    }
}
