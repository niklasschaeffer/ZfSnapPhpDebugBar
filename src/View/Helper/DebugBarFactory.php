<?php

namespace PhpDebugBar\View\Helper;

use DebugBar\DebugBar;
use PhpDebugBar\View\Helper\DebugBar as DebugBarHelper;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
final class DebugBarFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $debugbar DebugBar */
        $debugbar = $container->get('DebugBar');
        $renderer = $debugbar->getJavascriptRenderer();

        $renderer->setBaseUrl('/DebugBar/Resources/');
        $renderer->setBasePath('/DebugBar/Resources/');

        $config = $container->get('Config');
        $customStyle = $config['php-debug-bar']['view']['custom-style-path'];

        return new DebugBarHelper($renderer, $customStyle);
    }

    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator->getServiceLocator(), DebugBar::class);
    }

}
