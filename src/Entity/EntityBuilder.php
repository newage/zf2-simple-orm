<?php

namespace SimpleOrm\Entity;

use SimpleOrm\Exception\RuntimeException;
use Zend\Db\Sql\Select;

/**
 * Class EntityBuilder
 * @package SimpleOrm\Entity
 */
class EntityBuilder
{
    /**
     * @param EntityRelation|array $entityRelations
     */
    public function build($entityRelations)
    {
//        if (is_array($entityRelations)) {
//
//        }
//
//        if (!$entityRelations instanceof EntityRelation) {
//            throw new RuntimeException('Parameters for builder must be array or EntityRelation object');
//        }
        $mapping = include 'build/mapping.php';
        $select = new Select();
        foreach ($entityRelations as $path => $relation) {
            $entityMapping = $mapping[$relation];
            $select->from($entityMapping['table']);
            $columns = [];
            foreach ($entityMapping['properties'] as $property) {
                $columns = array_merge($columns, [$entityMapping['table'].'.'.$property['property'] => $property['column']['name']]);
            }
            $select->columns($columns);
        }

        $adapter = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
        echo $select->getSqlString($adapter->getPlatform()); die;
    }

    /**
     * Query executes and bind entities
     */
    public function execute()
    {

    }
}
