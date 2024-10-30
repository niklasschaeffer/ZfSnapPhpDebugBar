<?php

namespace PhpDebugBar\Listener;

use DebugBar\DataCollector\TimeDataCollector;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\View\Model\ModelInterface;
use Laminas\View\ViewEvent;

/**
 * @author witold
 */
class MeasureListener extends AbstractListenerAggregate
{

    private $timeCollector;
    private $lastMeasure;

    public function __construct(TimeDataCollector $timeCollector)
    {
        $this->timeCollector = $timeCollector;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('*', [$this, 'mesureToCollector'], $priority);
    }

    public function mesureToCollector(EventInterface $event)
    {
        if ($this->lastMeasure !== null && $this->timeCollector->hasStartedMeasure($this->lastMeasure)) {
            $this->timeCollector->stopMeasure($this->lastMeasure);
        }
        $this->lastMeasure = $event->getName();

        if ($event instanceof ViewEvent) {
            $model = $event->getParam('model');

            if ($model instanceof ModelInterface) {
                $this->lastMeasure .= ' (' . $model->getTemplate() . ')';
            }
        }
        $this->timeCollector->startMeasure($this->lastMeasure, $this->lastMeasure);
    }
}
