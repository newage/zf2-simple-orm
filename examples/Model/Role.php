<?php

namespace ExampleModel\Model;

use Newage\Annotations\Entity\Annotation;

/**
 * @Annotation\Table({"name":"roles"})
 */
class Role
{
    /**
     * @Annotation\Id()
     * @Annotation\Column({"type":"integer", "name":"id"})
     */
    protected $identifier;

    /**
     * @Annotation\Column({"type":"integer", "name":"parent_id", "default":0})
     */
    protected $parent;

    /**
     * @Annotation\Column({"type":"varchar", "length": 200, "unique": true, "name":"name"})
     */
    protected $name;
}
