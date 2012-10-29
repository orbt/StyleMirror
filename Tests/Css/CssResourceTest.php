<?php

namespace Orbt\StyleMirror\Tests\Css;

use Orbt\StyleMirror\Resource\CssResource;

class CssResourceTest extends \PHPUnit_Framework_TestCase
{
    const RESOURCE_CLASS = 'Orbt\StyleMirror\Resource\CssResource';

    /**
     * A CSS resource can be instantiated.
     */
    public function testCreate()
    {
        $resource = new CssResource('style.css', 'screen');
        $this->assertInstanceOf(self::RESOURCE_CLASS, $resource);
    }

    /**
     * A CSS resource returns its media type.
     *
     * @depends testCreate
     */
    public function testGetMediaType()
    {
        $resource = new CssResource('style.css', 'screen');
        $this->assertEquals('screen', $resource->getMediaType());
    }

    /**
     * A CSS resource is created using a URL and a base URL.
     *
     * @depends testGetMediaType
     */
    public function testFromUrl()
    {
        $resource = CssResource::fromUrl('http://example.com/style.css', 'http://example.com', 'screen');
        $this->assertInstanceOf(self::RESOURCE_CLASS, $resource);
        $this->assertEquals('style.css', $resource->getPath());
        $this->assertEquals('screen', $resource->getMediaType());
    }

    /**
     * A CSS resource is created using a URL and a base URL.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testFromUrlUnmatched()
    {
        CssResource::fromUrl('http://example.com/style.css', 'http://different.com');
    }
}
