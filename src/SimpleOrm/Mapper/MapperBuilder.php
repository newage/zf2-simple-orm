<?php

namespace SimpleOrm\Mapper;

use Zend\Stdlib\ArrayObject;
use Zend\Config\Writer\PhpArray;
use Zend\Config\Reader;

/**
 * Class MapperBuilder
 * @package SimpleOrm\Mapper
 */
class MapperBuilder
{
    const MAPPER_NAME = 'mapping.php';

    /**
     * Path to save generated maps
     * @var string
     */
    protected $buildPath;

    /**
     * Configuration array
     * @var array
     */
    protected $config;

    /**
     * Generate/update mapping
     * @param ArrayObject $spec
     */
    public function create(ArrayObject $spec)
    {
        $filePath = $this->getConfig('path') . self::MAPPER_NAME;
        $configArray = new ArrayObject();

        foreach ($spec['entities'] as &$entity) {
            if (isset($entity['entity'])) {
                $configArray[$entity['entity']] = $entity;
                unset($entity['entity']);
            }
        }

        $writer = new PhpArray();
        $writer->setUseBracketArraySyntax(true);
        $writer->toFile($filePath, $configArray);
    }

    /**
     * @param null $name
     * @return array
     */
    public function getConfig($name = null)
    {
        return $this->config[$name];
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}
