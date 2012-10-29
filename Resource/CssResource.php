<?php

namespace Orbt\StyleMirror\Resource;

use Orbt\ResourceMirror\Resource\GenericResource;

/**
 * Resource class encapsulating the media tag of the linked styles.
 */
class CssResource extends GenericResource
{
    /**
     * CSS media type.
     */
    protected $mediaType;

    /**
     * Creates a CSS resource from URL.
     */
    public static function fromUrl($cssUrl, $baseUrl, $mediaType = 'all')
    {
        // Match URL.
        if (strpos($cssUrl, $baseUrl) === false) {
            throw new \InvalidArgumentException('The CSS URL does not begin with the base URL');
        }

        // Create.
        $baseLength = strlen(rtrim($baseUrl, '/')) + 1;
        $path = substr($cssUrl, $baseLength);
        return new CssResource($path, $mediaType);
    }

    /**
     * Constructs a CSS resource.
     *
     * @param string $path
     *   CSS resource path.
     * @param string $mediaType
     *   A media identifier string. The media type may be composite.
     */
    public function __construct($path, $mediaType = 'all')
    {
        parent::__construct($path);
        $this->mediaType = $mediaType;
    }

    public function getMediaType()
    {
        return $this->mediaType;
    }
}
