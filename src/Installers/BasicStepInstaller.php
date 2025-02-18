<?php

namespace Mnhazim\PackageSetup\Installers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Mnhazim\PackageSetup\Installers\PackageInstaller;

class BasicStepInstaller extends PackageInstaller
{
    public function install($force = false)
    {
        $this->command->info('Installing ' . $this->config['name']);

        if (!$force && $this->checkComposerPackage($this->config['package'])) {
            $this->command->info('Package already installed.');
            // return;
        }

        // Install via composer
        $this->command->line('Running composer require...');
        $result = shell_exec("composer require {$this->config['package']}");

        if ($result === null) {
            $this->command->error("Failed to install {$this->config['package']} via Composer.");
            // return;
        }

        // Publish resources
        foreach ($this->config['publishes'] as $publish) {
            $this->command->line("Publishing {$publish['tag']}...");

            $params = [
                '--provider' => $publish['provider']
            ];

            if($publish['tag']){
                $params[] = ['--tag' => $publish['tag']];
            }

            Artisan::call('vendor:publish', $params);
        }

        // Run migrations if needed
        if ($this->config['has_migrations'] || $force) {
            $this->command->line('Running migrations...');
            try {
                Artisan::call('migrate');
            } catch (\Exception $e) {
                $this->command->error('Migration failed: ' . $e->getMessage());
                return;
            }
        }

        $this->command->info($this->config['name'] . ' installation completed!');
    }
}