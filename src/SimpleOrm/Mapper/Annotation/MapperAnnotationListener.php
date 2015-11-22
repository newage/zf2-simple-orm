<?php

namespace SimpleOrm\Mapper\Annotation;

use SimpleOrm\Entity\Annotation\Column;
use SimpleOrm\Entity\Annotation\Id;
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

        $this->listeners[] = $events->attach('configureProperty', [$this, 'handleIdAnnotation']);
        $this->listeners[] = $events->attach('configureProperty', [$this, 'handleColumnAnnotation']);
    }

    public function handleTableAnnotation(EventInterface $event)
    {
        $annotation = $event->getParam('annotation');
        if (!$annotation instanceof Table) {
            return;
        }

        $spec = $event->getParam('spec');
        $spec['entity'] = $event->getParam('name');
        $spec['table'] = $annotation->getName();
    }

    public function handleIdAnnotation(EventInterface $event)
    {
        $annotation = $event->getParam('annotation');
        if (!$annotation instanceof Id) {
            return;
        }

        $spec = $event->getParam('spec');
        $spec['autoincrement'] = true;
    }

    public function handleColumnAnnotation(EventInterface $event)
    {
        $annotation = $event->getParam('annotation');
        if (!$annotation instanceof Column) {
            return;
        }

        $spec = $event->getParam('spec');
        $spec['property'] = $event->getParam('name');
        $spec['column'] = $annotation->getName();
    }
}
