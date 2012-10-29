<?php

namespace Orbt\StyleMirror\Css;

use Orbt\StyleMirror\Resource\SingleUseQueue;
use Orbt\ResourceMirror\Resource\GenericResource;

/**
 * Scans a stylesheet for resources.
 */
class ResourceScanner
{
    protected $queue;

    public function __construct(SingleUseQueue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Scans CSS content for resources.
     *
     * @param GenericResource $resource
     * @param string $content
     */
    public function scan(GenericResource $resource, $content)
    {
        // Match all URL references.
        preg_match_all('!url\(\s*[\'"]?([^\'"):/]+(?:/[^\'"):/]+)*)[\'"]?\s*\)!i', $content, $matches);
        foreach ($matches[1] as $path) {
            $this->queue->add(new GenericResource($resource->resolvePath($path)));
        }
    }
}
