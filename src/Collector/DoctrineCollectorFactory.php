<?php

namespace PhpDebugBar\Collector;

use Interop\Container\ContainerInterface;
use DebugBar\Bridge\DoctrineCollector;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class DoctrineCollectorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $debugStack = $container->get('doctrine.configuration.orm_default')->getSQLLogger();
        return new DoctrineCollector($debugStack);
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, DoctrineCollector::class);
    }
}
