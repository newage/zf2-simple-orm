<?php

namespace SimpleOrm\Entity\Annotation;

/**
 * Class OneToOne
 *
 * @Annotation
 */
class OneToOne extends AbstractAnnotation
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
