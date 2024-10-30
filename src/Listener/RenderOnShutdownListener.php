<?php

namespace PhpDebugBar\Listener;

use DebugBar\JavascriptRenderer;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Http\Response;
use Laminas\Mvc\MvcEvent;

/**
 * @author witold
 */
class RenderOnShutdownListener extends AbstractListenerAggregate
{

    private $javascriptRenderer;
    private $enable;

    public function __construct(JavascriptRenderer $javascriptRenderer, $enable)
    {
        $this->javascriptRenderer = $javascriptRenderer;
        $this->enable = $enable;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        if ($this->enable === true) {
            $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, [$this, 'renderOnShutdown'], $priority);
        }
    }

    public function renderOnShutdown(MvcEvent $event)
    {
        $response = $event->getResponse();

        if (!$response instanceof Response) {
            return;
        }
        $contentTypeHeader = $response->getHeaders()->get('Content-type');

        if ($contentTypeHeader && $contentTypeHeader->getFieldValue() !== 'text/html') {
            return;
        }

        $this->javascriptRenderer->renderOnShutdown(false);
    }
}
