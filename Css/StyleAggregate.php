<?php

namespace Orbt\StyleMirror\Css;
use Orbt\ResourceMirror\Resource\MaterializedResource;

/**
 * Aggregate style sheet collection.
 */
class StyleAggregate
{
    protected $styles;

    public function __construct()
    {
        $this->styles = array();
    }

    /**
     * Adds a style sheet.
     */
    public function addStyle(MaterializedResource $resource, $mediaType = 'all')
    {
        $this->styles[$resource->getPath()] = array(
            'resource' => $resource,
            'content' => $resource->getContent(),
            'media' => $mediaType,
        );
    }

    /**
     * Gets an aggregated style sheet.
     */
    public function getAggregateStyle()
    {
        $styles = $this->rewritePaths($this->styles);
        $styles = $this->wrapMediaRules($styles);
        $content = $this->aggregateStyles($styles);
        $content = $this->moveImportsToStart($content);
        return $content;
    }

    /**
     * Rewrites the paths of referenced resources.
     */
    protected function rewritePaths(array $styles)
    {
        // TODO
        return $styles;
    }

    /**
     * Wraps resource content in media rules where appropriate.
     */
    protected function wrapMediaRules(array $styles)
    {
        // TODO
        return $styles;
    }

    /**
     * Aggregates style resources into one.
     */
    protected function aggregateStyles(array $styles)
    {
        // TODO
        return '';
    }

    /**
     * Moves import rules to the start of the style sheet.
     */
    protected function moveImportsToStart($content)
    {
        // TODO
        return $content;
    }
}
