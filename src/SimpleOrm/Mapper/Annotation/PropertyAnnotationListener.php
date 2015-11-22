<?php

namespace SimpleOrm\Mapper\Annotation;

use SimpleOrm\Entity\Annotation\Column;
use SimpleOrm\Entity\Annotation\Id;
use SimpleOrm\Entity\Annotation\OneToOne;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;

/**
 * Class PropertyAnnotationListener
 * @package SimpleOrm\Mapper\Annotation
 */
class PropertyAnnotationListener extends AbstractAnnotationListener
{
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('configureProperty', [$this, 'handleIdAnnotation']);
        $this->listeners[] = $events->attach('configureProperty', [$this, 'handleColumnAnnotation']);
        $this->listeners[] = $events->attach('configureProperty', [$this, 'handleOneToOneAnnotation']);
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
        $spec['column'] = $annotation->getName();
    }

    public function handleOneToOneAnnotation(EventInterface $event)
    {
        $annotation = $event->getParam('annotation');
        if (!$annotation instanceof OneToOne) {
            return;
        }

        $spec = $event->getParam('spec');
        $spec['oneToOne'] = $annotation->getName();
    }
}
