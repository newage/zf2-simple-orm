<?php

$config = [
    'modules' => [
        'Newage\Annotations',
    ],
    'annotations' => [
        'AnnotationBuilder' => [
            'models' => [
                [
                    'path' => 'examples/Model',
                    'namespace' => 'ExampleModel\Model'
                ]
            ]
        ],
        'MapperBuilder' => [
            'path' => 'build/'
        ]
    ],
    'db' => array(
        'driver'    => 'Pdo_Mysql',
        'database'  => 'test',
        'username'  => 'root',
        'password'  => '123456',
        'hostname'  => '172.17.0.2',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function (\Zend\ServiceManager\ServiceManager $serviceManager) {
                $adapterFactory = new Zend\Db\Adapter\AdapterServiceFactory();
                $adapter = $adapterFactory->createService($serviceManager);

                Zend\Db\TableGateway\Feature\GlobalAdapterFeature::setStaticAdapter($adapter);

                return $adapter;
            }
        )
    )
];

return $config;
