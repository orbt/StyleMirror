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
     * Constructs an aggregator.
     * @param ResourceMirror $mirror
     */
    public function __construct($mirror)
    {
        $this->mirror = $mirror;
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
                $aggregate->addStyle($resource, $mediaType());
            }
        }

        // Create resource with the aggregate style sheet.
        $data = $aggregate->getAggregateStyle();
        $hash = base64_encode(hash('sha256', $data, TRUE));
        $hash = strtr($hash, array('+' => '-', '/' => '_', '=' => ''));
        $file = 'style_'.$hash.'.css';
        $resource = new LocalResource($file, $data);
        return $resource;
    }
}
