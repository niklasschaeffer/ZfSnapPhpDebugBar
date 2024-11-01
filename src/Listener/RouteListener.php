<?php

namespace PhpDebugBar\Listener;

use DebugBar\DataCollector\ConfigCollector;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;

/**
 * @author witold
 */
final class RouteListener extends AbstractListenerAggregate
{
    private $debugBar;

    public function __construct(\DebugBar\DebugBar $debugBar) {
        $this->debugBar = $debugBar;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'addRouteToCollection'], $priority);
    }

    public function addRouteToCollection(MvcEvent $event)
    {
        $route = $event->getRouteMatch();
        $data = [
            'route_name' => $route->getMatchedRouteName(),
            'params' => $route->getParams(),
        ];
        $collector = new ConfigCollector($data, 'Route');

        $this->debugBar->addCollector($collector);
    }
}
