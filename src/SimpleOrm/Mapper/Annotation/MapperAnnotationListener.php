<?php

namespace SimpleOrm\Mapper\Annotation;

use SimpleOrm\Entity\Annotation\Table;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;

/**
 * Class MapperAnnotationListener
 * @package SimpleOrm\Mapper\Annotation
 */
class MapperAnnotationListener extends AbstractAnnotationListener
{

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('configureEntity', [$this, 'handleTableAnnotation']);
    }

    public function handleTableAnnotation(EventInterface $event)
    {
        $annotation = $event->getParam('annotation');
        if (!$annotation instanceof Table) {
            return;
        }

        $spec = $event->getParam('spec');
        $spec['name'] = $annotation->getName();
    }
}
