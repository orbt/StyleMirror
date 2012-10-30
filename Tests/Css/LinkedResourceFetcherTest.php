<?php

namespace Orbt\StyleMirror\Tests;

use Orbt\StyleMirror\Css\ResourceScanner;
use Orbt\StyleMirror\Css\LinkedResourceFetcher;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Orbt\ResourceMirror\ResourceMirror;
use Orbt\ResourceMirror\Resource\GenericResource;
use Orbt\StyleMirror\Resource\SingleUseQueue;

class LinkedResourceFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A linked resource fetcher can be instantiated.
     */
    public function testCreate()
    {
        $scanner = new ResourceScanner(new SingleUseQueue());
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', sys_get_temp_dir());
        $fetcher = new LinkedResourceFetcher($scanner, $mirror);
        $this->assertInstanceOf('Orbt\StyleMirror\Css\LinkedResourceFetcher', $fetcher);
    }

    /**
     * A linked resource fetcher is dispatched when materiailzing a resource.
     *
     * @depends testCreate
     */
    public function testDispatch()
    {
        $dispatcher = new EventDispatcher();
        $scanner = new ResourceScanner(new SingleUseQueue());
        $mirror = new ResourceMirror($dispatcher, 'http://example.com/', sys_get_temp_dir());
        $fetcher = new LinkedResourceFetcher($scanner, $mirror);
        $dispatcher->addSubscriber($fetcher);
        $resource = $mirror->materialize(new GenericResource('test.css'));
        $this->assertNotNull($resource);
    }
}
