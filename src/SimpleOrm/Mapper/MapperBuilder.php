<?php

namespace SimpleOrm\Mapper;

use Zend\Stdlib\ArrayObject;

/**
 * Class MapperBuilder
 * @package SimpleOrm\Mapper
 */
class MapperBuilder
{
    const MAPPER_NAME = 'generated_map.php';
    const BUILD_PATH = __DIR__ . '../../../build/';

    /**
     * Path to save generated maps
     * @var string
     */
    protected $buildPath;

    public function create(ArrayObject $spec)
    {

    }
}
