<?php

namespace ExampleModel\Model;

use SimpleOrm\Entity\EntityInterface;
use SimpleOrm\Entity\Annotation;

/**
 * @Annotation\Table({"name":"users"})
 */
class User
{
    /**
     * @Annotation\Id()
     * @Annotation\Column({"type":"integer", "name":"id"})
     */
    protected $identifier;

    /**
     * @Annotation\Column({"type":"varchar", "length": 200, "unique": true, "name":"name"})
     */
    protected $name;

    /**
     * @Annotation\Column({"type":"varchar", "length": 50, "name":"login"})
     * @Annotation\Unique({"index":"login_unq", "columns":"login"})
     */
    protected $login;

    /**
     * @Annotation\Column({"type":"integer", "name":"role_id"})
     * @Annotation\OneToOne({"targetEntity":"\ExampleModel\Model\Role", "columnName"="role_id", "referencedColumnName"="id"})
     */
    protected $role;

    /**
     * @Annotation\Column({"type":"varchar", "length": 50, "name": "password"})
     */
    protected $password;
}
