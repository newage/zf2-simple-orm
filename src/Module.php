<?php

namespace SimpleOrm;

use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

/**
 * Class Module
 * @package SimpleOrm
 */
class Module implements ConfigProviderInterface, ConsoleUsageProviderInterface
{
    public function getConsoleUsage(AdapterInterface $console)
    {
        $docs = [
            'Mapper:',
            'mapper generate' => 'Generate map for entities',
            'mapper test' => 'Build test collection'
        ];

        return $docs;
    }

    public function getConfig()
    {
        $config = require 'config/module.config.php';
        return $config;
    }
}
