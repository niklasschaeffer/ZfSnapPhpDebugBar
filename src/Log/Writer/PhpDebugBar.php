<?php

namespace PhpDebugBar\Log\Writer;

use DebugBar\DataCollector\MessagesCollector;
use Laminas\Log\Writer\AbstractWriter;

/**
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class PhpDebugBar extends AbstractWriter
{
    protected $messagesCollector;
    private $priorityMap = [
        'warn' => 'warning',
        'err' => 'error',
    ];

    public function __construct(MessagesCollector $debugbar)
    {
        $this->messagesCollector = $debugbar;
    }

    /**
     * @param array $event
     */
    protected function doWrite(array $event)
    {
        $priority = $this->priorityMap($event['priorityName']);
        $this->messagesCollector->addMessage($event['message'], $priority);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function priorityMap($name)
    {
        $name = strtolower($name);

        if (isset($this->priorityMap[$name])) {
            return $this->priorityMap[$name];
        }
        return $name;
    }
}
