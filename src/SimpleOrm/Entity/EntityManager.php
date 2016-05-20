<?php

namespace SimpleOrm\Entity;

use SplObjectStorage;
use InvalidArgumentException;
use Zend\Db\Sql\Select;
use Zend\Stdlib\ArrayObject;

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
     * @var ArrayObject
     */
    protected $children;

    /**
     * EntityManager constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayObject();
    }

    /**
     * Join entity
     * @param $entity
     * @param Select $filter
     * @return EntityManager
     */
    public function join($entity, $filter = null)
    {
        $entity = new EntityManager($this->createEntity($entity));
        $this->getChildren()->append([$entity, $filter]);

        return $entity;
    }

    /**
     * Execute
     * @return array
     */
    public function execute()
    {
        $collection = [];
        foreach ($this->children as $children) {
            list($entity, $filter) = $children;
            /* Apply filter to current entity */
            if ($filter instanceof Select) {

            }

            /* Call children if exists */
            if ($entity->getChildren()) {

            }

            $collection[] = $entity;
        }

        return $collection;
    }

    /**
     * @return ArrayObject
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param ArrayObject $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }
    
    /**
     * Create entity
     * @param $entity
     */
    protected function createEntity($entity)
    {
        if (is_string($entity) && class_exists($entity)) {
            $entity = new $entity();
        } else {
            throw new InvalidArgumentException('Entity does not exists: ' . $entity);
        }

        if (!$entity instanceof EntityInterface) {
            throw new InvalidArgumentException('Entity does not implements `EntityInterface`: ' . get_class($entity));
        }

        return $entity;
    }
}
