<?php

namespace SimpleOrm\Entity\Annotation;

/**
 * Class Column
 *
 * @Annotation
 */
class Column extends AbstractAnnotation
{
    /**
     * Retrieve the name
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->value;
    }
}
