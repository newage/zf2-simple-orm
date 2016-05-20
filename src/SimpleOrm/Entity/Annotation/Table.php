<?php

namespace SimpleOrm\Entity\Annotation;

/**
 * Class Table
 *
 * @Annotation
 */
class Table extends AbstractAnnotation
{
    /**
     * Retrieve the name
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->value['name'];
    }
}
