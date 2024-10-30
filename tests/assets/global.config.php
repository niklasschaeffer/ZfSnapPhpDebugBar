<?php
return [
    'controllers' => [
        'invokables' => [
            PhpDebugBar\Tests\Functional\DummyController::class => PhpDebugBar\Tests\Functional\DummyController::class,
        ],
    ],
    'php-debug-bar' => [
        'auto-append-assets' => true,
        'render-on-shutdown' => false,
        'view' => [
            'debugbar-resources' => __DIR__.'/../../vendor/maximebf/debugbar/src/DebugBar/Resources/',
        ],
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => PhpDebugBar\Tests\Functional\DummyController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'error' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/error',
                    'defaults' => [
                        'controller' => PhpDebugBar\Tests\Functional\DummyController::class,
                        'action' => 'error',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Laminas\Db\Adapter\Adapter::class => Laminas\Db\Adapter\AdapterServiceFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'template_map' => [
            'layout/layout' => __DIR__ . '/views/layout.phtml',
            'dummy/index' => __DIR__ . '/views/view.phtml',
            'error' => __DIR__ . '/views/view.phtml',
        ],
    ],
];
