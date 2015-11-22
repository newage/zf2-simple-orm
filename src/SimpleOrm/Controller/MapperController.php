<?php

namespace SimpleOrm\Controller;

use ExampleModel\Model\User;
use SimpleOrm\Entity\Annotation\AnnotationBuilder;
use SimpleOrm\Mapper\MapperBuilder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\ColorInterface as Color;
use Zend\Console\Adapter\AdapterInterface as Console;

/**
 * Class MapperController
 * @package SimpleOrm\Controller
 */
class MapperController extends AbstractActionController
{
    /**
     *
     */
    public function generateAction()
    {
        /* @var $console Console */
        $console = $this->getServiceLocator()->get('console');
        $config = $this->getServiceLocator()->get('config');

        $mapperBuilder = new MapperBuilder();
        $mapperBuilder->setConfig($config['SimpleOrm']['MapperBuilder']);

        $annotationBuilder = new AnnotationBuilder();
        $annotationBuilder->setMapperBuilder($mapperBuilder);
        $annotationBuilder->create(new User());

        $console->writeLine('Map has been generated successful', Color::GREEN);
    }
}
