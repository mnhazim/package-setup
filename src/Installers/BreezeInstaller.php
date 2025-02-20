<?php

namespace Mnhazim\PackageSetup\Installers;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Mnhazim\PackageSetup\Installers\PackageInstaller;

class BreezeInstaller extends PackageInstaller
{
    public function install($force = false)
    {
        $this->command->info('Installing ' . $this->config['name']);

        if (!$force && $this->checkComposerPackage($this->config['package'])) {
            $this->command->info('Package already installed.');
            return;
        }

        // Install via composer
        $this->command->line('Running composer require...');
        $result = shell_exec("composer require {$this->config['package']}");

        if ($result === null) {
            $this->command->error("Failed to install {$this->config['package']} via Composer.");
            return;
        }

        // $command = "breeze:install {$this->config['stack']}";
        Artisan::call('breeze:install', ['stack' => $this->config['stack']]);
        Artisan::call('migrate');
        
        $this->command->info($this->config['name'] . ' installation completed!');
    }
}