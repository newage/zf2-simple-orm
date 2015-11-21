<?php

namespace SimpleOrm\Mapper\Annotation;

/**
 * Class Table
 *
 * @Annotation
 */
class Table
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Receive and process the contents of an annotation
     *
     * @param  array $data
     * @throws Exception\DomainException if a 'value' key is missing, or its value is not a string
     */
    public function __construct(array $data)
    {
        if (!isset($data['value']) || !is_array($data['value'])) {
            throw new \Exception(sprintf(
                '%s expects the annotation to define an array; received "%s"',
                get_class($this),
                isset($data['value']) ? gettype($data['value']) : 'null'
            ));
        }
        $this->value = $data['value'];
    }

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
