<?php

namespace Mnhazim\PackageSetup\Installers;

use Illuminate\Console\Command;

abstract class PackageInstaller
{
    protected $command;
    protected $config;

    public function __construct(Command $command, array $config)
    {
        $this->command = $command;
        $this->config = $config;
    }

    /**
     * Create a new instance of the appropriate installer
     *
     * @param array $config
     * @param Command $command
     * @return PackageInstaller
     */
    public static function create($config, Command $command)
    {
        $installer = $config['installer'];
        return new $installer($command, $config);
    }

    /**
     * Install the package
     *
     * @param bool $force
     * @return void
     */
    abstract public function install($force = false);

    /**
     * Check if a composer package is installed
     *
     * @param string $package
     * @return bool
     */
    protected function checkComposerPackage($package)
    {
        try {
            return \Composer\InstalledVersions::isInstalled($package);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Run shell command and return result
     *
     * @param string $command
     * @return string|null
     */
    protected function runShellCommand($command)
    {
        return shell_exec($command);
    }

    /**
     * Log information to the console
     *
     * @param string $message
     * @return void
     */
    protected function info($message)
    {
        $this->command->info($message);
    }

    /**
     * Log error to the console
     *
     * @param string $message
     * @return void
     */
    protected function error($message)
    {
        $this->command->error($message);
    }

    /**
     * Log line to the console
     *
     * @param string $message
     * @return void
     */
    protected function line($message)
    {
        $this->command->line($message);
    }
}