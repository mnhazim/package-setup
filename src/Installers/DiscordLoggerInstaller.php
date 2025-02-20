<?php

namespace Mnhazim\PackageSetup\Installers;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DiscordLoggerInstaller extends PackageInstaller
{
    public function install($force = false)
    {
        $this->command->info('Installing ' . $this->config['name']);

        // if (!$force && $this->checkComposerPackage($this->config['package'])) {
        //     $this->command->info('Package already installed.');
        //     return;
        // }

        // // Install via composer
        // $this->command->line('Running composer require...');
        // $result = shell_exec("composer require {$this->config['package']}");

        // if ($result === null) {
        //     $this->command->error("Failed to install {$this->config['package']} via Composer.");
        //     return;
        // }

        $this->updateConfigLogging();
        $this->updateEnvFile();

        $this->command->info($this->config['name'] . ' installation completed!');
    }

    public function updateConfigLogging()
    {
        $configPath = base_path('config/logging.php');
        $config = File::get($configPath);

        // Check if Discord configuration already exists
        if (strpos($config, "'discord' =>") !== false) {
            $this->command->info('Discord logger configuration already exists.');
            return;
        }

        // Find the channels array start
        $pattern = "/'channels'\s*=>\s*\[\s*/";
        if (!preg_match($pattern, $config)) {
            $this->command->error('Could not locate channels configuration in logging.php');
            return;
        }

        // Prepare Discord configuration
        $discordConfig = "        'discord' => [
            'driver' => 'custom',
            'via'    => MarvinLabs\DiscordLogger\Logger::class,
            'level'  => 'debug',
            'url'    => env('LOG_DISCORD_WEBHOOK_URL'),
            'ignore_exceptions' => env('LOG_DISCORD_IGNORE_EXCEPTIONS', false),
        ],\n";

        // Insert Discord configuration after channels array opening
        $config = preg_replace($pattern, "'channels' => [\n" . $discordConfig, $config, 1);

        // Create backup of original file
        $backupPath = $configPath . '.backup.' . date('Y-m-d-His');
        File::copy($configPath, $backupPath);

        try {
            // Save the updated configuration
            File::put($configPath, $config);
            $this->command->info('Discord logger configuration added to config/logging.php');
            $this->command->info('Stack configuration updated');
            $this->command->info('Backup created at: ' . $backupPath);
        } catch (\Exception $e) {
            $this->command->error('Failed to update config file: ' . $e->getMessage());
            // Restore backup if save failed
            if (File::exists($backupPath)) {
                File::copy($backupPath, $configPath);
                $this->command->info('Original configuration restored from backup');
            }
        }

        // remove backup
        File::delete($backupPath);
    }
    protected function updateEnvFile()
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        $variables = [
            'LOG_DISCORD_WEBHOOK_URL' => '',
            'LOG_DISCORD_IGNORE_EXCEPTIONS' => 'false'
        ];

        // Handle regular variables
        foreach ($variables as $key => $defaultValue) {
            if (strpos($envContent, $key . '=') === false) {
                $envContent .= "\n" . $key . '=' . $defaultValue;
                $this->command->info("Added {$key} to .env file");
            }
        }

        // Handle LOG_STACK specially
        $stackPattern = '/LOG_STACK=(.*?)(\n|$)/';
        if (preg_match($stackPattern, $envContent, $matches)) {
            // LOG_STACK exists, check if discord is in the stack
            $currentStack = trim($matches[1]);
            $stackChannels = array_map('trim', explode(',', $currentStack));

            if (!in_array('discord', $stackChannels)) {
                // Add discord to existing channels
                $stackChannels[] = 'discord';
                $newStack = implode(',', $stackChannels);

                // Replace existing LOG_STACK value
                $envContent = preg_replace(
                    $stackPattern,
                    "LOG_STACK=" . $newStack . "\n",
                    $envContent
                );
                $this->command->info("Updated LOG_STACK to include discord");
            } else {
                $this->command->info("LOG_STACK already includes discord");
            }
        } else {
            // LOG_STACK doesn't exist, add it with default values
            $envContent .= "\nLOG_STACK=stack,discord";
            $this->command->info("Added LOG_STACK with default channels");
        }

        try {
            File::put($envPath, $envContent);
            $this->command->info("Environment variables updated successfully");
        } catch (\Exception $e) {
            $this->command->error('Failed to update .env file: ' . $e->getMessage());
        }
    }
}