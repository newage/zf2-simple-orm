<?php

namespace SimpleOrm\Entity;

use SimpleOrm\Exception;
use Zend\Db\Sql\Select;

class EntityRelation
{
    protected $entity;

    protected $filter;

    protected $children;


    /**
     * Constructor
     *
     * @param EntityInterface $entity TableName in service manager
     * @param \Zend\Db\Sql\Select $filter
     */
    public function __construct(EntityInterface $entity, $filter = null)
    {
        $this->setEntity($entity);
        $this->setFilter($filter);
    }

    /**
     * Add child to relation
     *
     * @param EntityInterface $entity
     * @param \Zend\Db\Sql\Select $filter
     * @param bool $count
     * @return $this
     * @throws Exception\InvalidArgumentException
     */
    public function addChild(EntityInterface $entity, $filter = null, $count = false)
    {
        if (is_string($entity) || is_array($entity)) {
            $childTable = new EntityRelation($entity, $filter, $count);
        } else {
            throw new Exception\InvalidArgumentException('Invalid type the first param of addChild()');
        }

        $this->children[] = $childTable;
        return $childTable;
    }

    public function getName()
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     */
    protected function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param null|Select $filter
     */
    protected function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function isChildren()
    {
        return count($this->children) > 0;
    }
}
