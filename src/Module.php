<?php

namespace Newage\SimpleOrm;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 * @package SimpleOrm
 */
class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        $config = require 'config/module.config.php';
        return $config;
    }
}
