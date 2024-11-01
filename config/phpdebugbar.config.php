<?php

return [
    'php-debug-bar' => [
        'view' => [
            'custom-style-path' => 'php-debug-bar.css',
            'debugbar-resources' => __DIR__.'/../../../maximebf/debugbar/src/DebugBar/Resources/',
            'custom-resources' => __DIR__.'/../assets/',
        ],
        'enabled' => true,
        'auto-append-assets' => true,
        'render-on-shutdown' => true,
        'zend-db-adapter-service-name' => Laminas\Db\Adapter\Adapter::class,
        // ServiceManager service keys to inject collectors
        // http://phpdebugbar.com/docs/data-collectors.html
        'collectors' => [
            // uncomment if you use Doctrine ORM
            //DebugBar\Bridge\DoctrineCollector::class,
        ],
        // ServiceManager service key to inject storage
        // http://phpdebugbar.com/docs/storage.html
        'storage' => null,
    ],
    'service_manager' => [
        'invokables' => [
            DebugBar\DebugBar::class => DebugBar\StandardDebugBar::class,
        ],
        'factories' => [
            'debugbar' => PhpDebugBar\Service\PhpDebugBarFactory::class,
            PhpDebugBar\Log\Writer\PhpDebugBar::class => PhpDebugBar\Log\Writer\PhpDebugBarFactory::class,
            DebugBar\Bridge\DoctrineCollector::class => PhpDebugBar\Collector\DoctrineCollectorFactory::class,
        ],
        'delegators' => [
            // uncomment if you use Doctrine ORM
            //'doctrine.configuration.orm_default' => [
            //    ZfSnapPhpDebugBar\Delegator\DoctrineConfigurationDelegatorFactory::class,
            //],
        ],
    ],
    'controllers' => [
        'factories' => [
            PhpDebugBar\Controller\Resources::class => PhpDebugBar\Controller\ResourcesFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'debugbar' => PhpDebugBar\View\Helper\DebugBarFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'phpdebugbar-resource' => [
                'type' => 'regex',
                'options' => [
                    'regex' => '/DebugBar/Resources/(?<resource>[a-zA-Z0-9_.\-/]+)',
                    'spec' => '/DebugBar/Resources/%resource%',
                    'defaults' => [
                        'controller' => PhpDebugBar\Controller\Resources::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'phpdebugbar-custom-resource' => [
                'type' => 'regex',
                'options' => [
                    'regex' => '/phpdebugbar/resources/(?<resource>[a-zA-Z0-9_.\-/]+)',
                    'spec' => '/phpdebugbar/resources/%resource%',
                    'defaults' => [
                        'controller' => PhpDebugBar\Controller\Resources::class,
                        'action' => 'custom',
                    ],
                ],
            ],
        ],
    ],
];
