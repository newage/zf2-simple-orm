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
class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ConsoleUsageProviderInterface
{
    public function getConsoleUsage(AdapterInterface $console)
    {
        $docs = [
            'Mapper:',
            'mapper generate' => 'Generate map for entities'
        ];

        return $docs;
    }

    public function getAutoloaderConfig()
    {
        return array(
//            'Zend\Loader\ClassMapAutoloader' => array(
//                __DIR__ . '/autoload_classmap.php',
//            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        $config = require __DIR__ . '/../../config/module.config.php';
        return $config;
    }
}
