<?php

namespace Orbt\StyleMirror\Css;

use Orbt\ResourceMirror\Resource\Collection;
use Orbt\ResourceMirror\Resource\LocalResource;
use Orbt\StyleMirror\Resource\CssResource;
use Orbt\ResourceMirror\Resource\MaterializedResource;
use Orbt\ResourceMirror\ResourceMirror;

/**
 * CSS aggregator service.
 */
class Aggregator
{
    /**
     * @var ResourceMirror
     */
    protected $mirror;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * Constructs an aggregator.
     * @param ResourceMirror $mirror
     * @param string $prefix
     */
    public function __construct($mirror, $prefix)
    {
        $this->mirror = $mirror;
        $this->prefix = $prefix;
    }

    /**
     * Aggregates a collection of CSS resources.
     *
     * @param Collection $collection
     * @return LocalResource
     */
    public function aggregate($collection)
    {
        // Ensure the collection is materialized.
        $collection = $this->mirror->materializeCollection($collection);

        // Create aggregate collection to accumulate style sheets.
        $aggregate = new StyleAggregate();
        foreach ($collection as $resource) {
            if ($resource instanceof MaterializedResource) {
                $internalResource = $resource->getResource();
                $mediaType = 'all';
                if ($internalResource instanceof CssResource) {
                    $mediaType = $internalResource->getMediaType();
                }
                $aggregate->addStyle($resource, $mediaType);
            }
        }

        // Create resource with the aggregate style sheet.
        $data = $aggregate->getAggregateStyle();
        $hash = sha1($data);
        $file = $this->prefix.$hash.'.css';
        $resource = new LocalResource($file, $data);
        return $resource;
    }
}
