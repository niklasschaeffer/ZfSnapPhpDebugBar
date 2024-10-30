<?php

namespace ZfSnapPhpDebugBar\Controller;

use Interop\Container\ContainerInterface;

final class ResourcesFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator();

        $config = $container->get('config')['php-debug-bar']['view'];

        return new Resources($config['debugbar-resources'], $config['custom-resources']);
    }
}
