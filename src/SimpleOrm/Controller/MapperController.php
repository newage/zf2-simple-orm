<?php

namespace SimpleOrm\Controller;

use SimpleOrm\Entity\Annotation\AnnotationBuilder;
use SimpleOrm\Entity\EntityManager;
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
     * Generate mapper file
     */
    public function generateAction()
    {
        /* @var $console Console */
        $console = $this->getServiceLocator()->get('console');
        $config = $this->getServiceLocator()->get('config');

        $mapperBuilder = new MapperBuilder();
        $mapperBuilder->setConfig($config['SimpleOrm']['MapperBuilder']);

        $annotationBuilder = new AnnotationBuilder();
        $annotationBuilder->setOptions($config['SimpleOrm']['AnnotationBuilder']);
        $annotationBuilder->setMapperBuilder($mapperBuilder);
        $annotationBuilder->create();

        $console->writeLine('Map has been generated successful', Color::GREEN);
    }

    public function testAction()
    {
        $manager = new EntityManager();
        $manager->join('ExampleModel\\Model\\User')->join('ExampleModel\\Model\\Role');
        $collection = $manager->execute();
        var_dump($collection); die();
    }
}
