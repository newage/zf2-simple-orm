<?php

$config = [
    'SimpleOrm' => [
        'AnnotationBuilder' => [
            'models' => [
                [
                    'path' => __DIR__ . '/../examples/ExampleModel/Model',
                    'namespace' => 'ExampleModel\Model'
                ]
            ]
        ],
        'MapperBuilder' => [
            'path' => __DIR__ . '/../build/'
        ]
    ],
    'controllers' => [
        'invokables' => [
            'SimpleOrm\Controller\Mapper' => 'SimpleOrm\Controller\MapperController'
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'generate' => [
                    'options' => [
                        'route'    => 'mapper generate',
                        'defaults' => [
                            'controller' => 'SimpleOrm\Controller\Mapper',
                            'action'     => 'generate'
                        ]
                    ]
                ],
                'test' => [
                    'options' => [
                        'route'    => 'test',
                        'defaults' => [
                            'controller' => 'SimpleOrm\Controller\Mapper',
                            'action'     => 'test'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'db' => array(
        'driver'    => 'Pdo_Mysql',
        'database'  => 'test',
        'username'  => 'root',
        'password'  => '123456',
        'hostname'  => '127.0.0.1',
        'unix_socket' => '', // for local sphinx fast connection
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
