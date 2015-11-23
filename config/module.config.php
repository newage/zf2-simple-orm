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
                ]
            ]
        ]
    ]
];

return $config;
