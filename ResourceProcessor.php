<?php

namespace Orbt\ResourceProcessor;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Guzzle\Common\Collection;
use Guzzle\Http\Client;

/**
 * A generic resource processor.
 *
 * A resource processor takes care of processing them by event listeners.
 */
class ResourceProcessor
{
    /**
     * Event dispatcher.
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Creates a resource processor for a backend server.
     *
     * @param EventDispatcherInterface $dispatcher
     *   Event dispatcher.
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}
