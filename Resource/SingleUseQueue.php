<?php

namespace Orbt\StyleMirror\Resource;

use Orbt\ResourceMirror\Resource\Collection;

/**
 * Queue for resources to be collected once.
 */
class SingleUseQueue
{
    protected $queue;
    protected $added;

    public function __construct()
    {
        $this->queue = new Collection();
        $this->added = array();
    }

    /**
     * Adds a resource to the queue.
     *
     * @param \Orbt\ResourceMirror\Resource\Resource $resource
     */
    public function add($resource)
    {
        if (!isset($this->added[$path = $resource->getPath()])) {
            $this->queue->add($resource);
            $this->added[$path] = true;
        }
    }

    /**
     * Returns and empties the current queue.
     */
    public function flush()
    {
        $queue = $this->queue;
        $this->queue = new Collection();
        return $queue;
    }
}
