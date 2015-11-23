<?php

namespace SimpleOrm\Entity;

use SplObjectStorage;
use InvalidArgumentException;

/**
 * Class EntityManager
 * @package SimpleOrm\Entity
 */
class EntityManager
{
    /**
     * Registered entities
     * @var string
     */
    protected $entity;

    /**
     * @var SplObjectStorage
     */
    protected $children;

    /**
     * EntityManager constructor.
     * @param string|EntityInterface $entity
     */
    public function __construct($entity)
    {
        $this->entity = $this->createEntity($entity);
        $this->children = new SplObjectStorage();
    }

    /**
     * Join entity
     * @param $entity
     * @return EntityManager
     */
    public function join($entity)
    {
        $entity = new EntityManager($this->createEntity($entity));
        $this->children->attach($entity);

        return $entity;
    }

    /**
     * Create entity
     * @param $entity
     */
    protected function createEntity($entity)
    {
        if (is_string($entity) && class_exists($entity)) {
            $this->entity = new $entity();
        } else {
            throw new InvalidArgumentException('Entity does not exists: ' . $entity);
        }

        if (!$entity instanceof EntityInterface) {
            throw new InvalidArgumentException('Entity does not implements `EntityInterface`: ' . get_class($entity));
        }

        return $entity;
    }
}
