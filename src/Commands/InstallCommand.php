<?php

namespace Mnhazim\PackageSetup\Commands;

use Composer\InstalledVersions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Mnhazim\PackageSetup\Config\PackageConfig;
use Mnhazim\PackageSetup\Installers\PackageInstaller;

class InstallCommand extends Command
{
    protected $signature = 'package-setup:install {--force : Force installation even if already installed}';

    protected $description = 'Setup project with predefined configuration';

    public function handle()
{
    $this->info('Starting setup process...');
    
    $force = $this->option('force');
    $config = new PackageConfig();
    
    // Install packages
    $this->info('Installing packages...');
    foreach ($config->getPackages() as $package) {
        $installer = PackageInstaller::create($package, $this);
        $installer->install($force);
    }

    // // Install components and templates
    // $this->info('Installing components and templates...');
    // $componentInstaller = new ComponentInstaller($this, [
    //     'components' => $config->getComponents(),
    //     'templates' => $config->getTemplates()
    // ]);
    // $componentInstaller->install($force);

    $this->info('Setup completed successfully!');
}
    // protected function installSpatieMediaLibrary($force = false)
    // {
    //     $this->info('Checking Spatie Media Library...');

    //     // if ($this->checkComposerPackage('spatie/laravel-medialibrary') && !$force) {
    //     //     $this->info('Spatie Media Library is already installed.');

    //     //     if (Schema::hasTable('media')) {
    //     //         $this->info('Media library tables already exist.');
    //     //         return;
    //     //     }
    //     // }

    //     $this->info('Installing Spatie Media Library...');
    //     $this->line('Running composer require...');
    //     $result = shell_exec('composer require spatie/laravel-medialibrary:*');

    //     if ($result === null) {
    //         $this->error('Failed to install spatie/laravel-medialibrary via Composer.');
    //     }

    //     // Check if config file already exists
    //     $configPath = config_path('media-library.php');
    //     if (!File::exists($configPath) || $force) {
    //         $this->line('Publishing configuration and migrations...');
            
    //         // Publish config
    //         Artisan::call('vendor:publish', [
    //             '--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider',
    //             '--tag' => 'medialibrary-config'
    //         ]);
            
    //         // Publish migrations
    //         Artisan::call('vendor:publish', [
    //             '--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider',
    //             '--tag' => 'medialibrary-migrations'
    //         ]);
    //     } else {
    //         $this->info('Configuration file already exists.');
    //     }

    //     if (!Schema::hasTable('media') || $force) {
    //         $this->line('Running migrations...');
    //         try {
    //             Artisan::call('migrate');
    //         } catch (\Exception $e) {
    //             $this->error('Migration failed: ' . $e->getMessage());
    //             return;
    //         }
    //     } else {
    //         $this->info('Migrations already run.');
    //     }

    //     $this->info('Spatie Media Library installation completed!');
    // }

    // protected function checkComposerPackage($package)
    // {
    //     try {
    //         return InstalledVersions::isInstalled($package);
    //     } catch (\Exception $e) {
    //         return false;
    //     }
    // }
}