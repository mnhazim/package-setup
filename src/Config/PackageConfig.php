<?php

namespace Mnhazim\PackageSetup\Config;

class PackageConfig
{
    protected $config;

    public function __construct()
    {
        $this->config = config('package-setup');
    }

    public function getPackages()
    {
        return $this->config['packages'] ?? [];
    }

    public function getComponents()
    {
        return $this->config['components'] ?? [];
    }

    public function getTemplates()
    {
        return $this->config['templates'] ?? [];
    }
}