<?php

namespace Orbt\ResourceManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Guzzle\Common\Collection;
use Guzzle\Http\Client;

/**
 * A generic resource manager.
 *
 * A resource manager takes care of fetching resources and processing them by dispatching event using the Symfony Event
 * Dispatcher component.
 */
class ResourceManager
{
    /**
     * Event dispatcher.
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Backend server base.
     * @var string
     */
    private $backendBaseUrl;

    /**
     * Guzzle backend client.
     * @var Client
     */
    private $client;

    /**
     * Creates a resource manager for a backend server.
     *
     * @param EventDispatcherInterface $dispatcher
     *   Event dispatcher.
     * @param string $backendBaseUrl
     *   Backend server base URL.
     * @param array|Collection $clientConfig
     *   Backend Guzzle client options.
     */
    public function __construct(EventDispatcherInterface $dispatcher, $backendBaseUrl, $clientConfig = NULL)
    {
        $this->dispatcher = $dispatcher;
        $this->backendBaseUrl = $backendBaseUrl;
        $this->client = new Client($backendBaseUrl, $clientConfig);
    }

    /**
     * Returns the backend client for this manager.
     */
    public function getClient()
    {
        return $this->client;
    }
}
