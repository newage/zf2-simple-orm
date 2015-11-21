<?php

$config = [
    'AnnotationBuilder' => [
        'cache_path' => __DIR__ . '../build/',
        'models' => [
            ['path' => __DIR__ . '../example/Model/']
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
                ]
            ]
        ]
    ]
];

return $config;
