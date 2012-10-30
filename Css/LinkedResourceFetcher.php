<?php

namespace Orbt\StyleMirror\Css;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Orbt\ResourceMirror\ResourceMirror;
use Orbt\ResourceMirror\Event\ResourceMaterializeEvent;
use Orbt\ResourceMirror\Event\ResourceEvents;
use Orbt\ResourceMirror\Resource\MaterializedResource;

/**
 * A resource event listener that fetches all linked resources in CSS.
 */
class LinkedResourceFetcher implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ResourceEvents::MATERIALIZE => 'onResourceMaterialize',
        );
    }

    /**
     * @var ResourceScanner
     */
    protected $scanner;

    /**
     * @var ResourceMirror
     */
    protected $mirror;

    /**
     * Creates a linked fetcher.
     */
    public function __construct(ResourceScanner $scanner, ResourceMirror $mirror)
    {
        $this->scanner = $scanner;
        $this->mirror = $mirror;
    }

    /**
     * Scans all linked resources.
     */
    public function onResourceMaterialize(ResourceMaterializeEvent $e)
    {
        /** @var $resource MaterializedResource */
        $resource = $e->getResource();

        // Only scan resources with .css extension.
        if (preg_match('/\.css$/i', $resource->getPath())) {
            $this->scanner->scan($resource, $resource->getContent());
            $collection = $this->scanner->getQueue()->flush();
            // Materialize non-existing resources.
            foreach ($collection as $linkedResource) {
                if (!$this->mirror->exists($linkedResource)) {
                    $this->mirror->materialize($linkedResource);
                }
            }
        }
    }
}
