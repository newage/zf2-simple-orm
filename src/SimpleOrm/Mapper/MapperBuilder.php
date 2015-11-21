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

    /**
     * Path to save generated maps
     * @var string
     */
    protected $buildPath;

    public function create(ArrayObject $specification)
    {

    }

    /**
     * @return string
     */
    public function getBuildPath()
    {
        return $this->buildPath;
    }

    /**
     * @param string $buildPath
     */
    public function setBuildPath($buildPath)
    {
        $this->buildPath = $buildPath;
    }
}
