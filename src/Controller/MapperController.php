<?php

namespace SimpleOrm\Controller;

use ExampleModel\Model\Role;
use ExampleModel\Model\User;
use SimpleOrm\Entity\Annotation\AnnotationBuilder;
use SimpleOrm\Entity\EntityBuilder;
use SimpleOrm\Entity\EntityRelation;
use SimpleOrm\Mapper\MapperBuilder;
use Zend\Console\ColorInterface as Color;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Mvc\Controller\AbstractConsoleController;

/**
 * Class MapperController
 * @package SimpleOrm\Controller
 */
class MapperController extends AbstractConsoleController
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
//        $relations = new EntityRelation(new User());
//        $relations->addChild(new Role());
        $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $builder = new EntityBuilder();
        $builder->build([
            User::class
        ]);
        $collection = $builder->execute();
        var_dump($collection);
        die();
    }
}
