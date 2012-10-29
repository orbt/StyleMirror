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
        foreach ($styles as &$style) {
            /** @var $resource MaterializedResource */
            $resource = $style['resource'];
            $replaceCallback = function ($match) use ($resource) {
                return "url('".$resource->resolvePath($match[1])."')";
            };
            $style['content'] = preg_replace_callback(ResourceScanner::PATH_PATTERN, $replaceCallback, $style['content']);
        }
        return $styles;
    }

    /**
     * Wraps resource content in media rules where appropriate.
     */
    protected function wrapMediaRules(array $styles)
    {
        foreach ($styles as &$style) {
            // Wrap in media rule if a media rule does not already exist in a non-all media style.
            if ($style['media'] != 'all' && strpos($style['content'], '@media') === false) {
                $style['content'] = '@media '.$style['media'].' {'.$style['content'].'}';
            }
        }
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
