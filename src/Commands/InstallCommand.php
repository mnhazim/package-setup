<?php

namespace Mnhazim\PackageSetup\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'package-setup:install';

    protected $description = 'Setup project with predefined configuration';

    public function handle()
    {
        dd(123);
    }
}