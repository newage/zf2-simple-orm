<?php

namespace SimpleOrm\Controller;

use SimpleOrm\Example\Model\User;
use SimpleOrm\Entity\Annotation\AnnotationBuilder;
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

        $annotationBuilder = new AnnotationBuilder();
        $annotationBuilder->create(new User());

        $console->writeLine('Map has been generated successful', Color::GREEN);
    }
}
