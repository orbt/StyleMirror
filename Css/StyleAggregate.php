<?php

namespace Orbt\StyleMirror\Css;

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
    public function addStyle($path, $content, $mediaType = 'all')
    {
        $this->styles[$path] = array(
            'content' => $content,
            'media' => $mediaType,
        );
    }

    /**
     * Gets an aggregated style sheet.
     */
    public function getAggregateStyle()
    {
        // TODO
        return '';
    }
}
