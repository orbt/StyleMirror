<?php

namespace Orbt\StyleMirror\Tests\Css;

use Orbt\StyleMirror\Css\Aggregator;
use Orbt\ResourceMirror\Resource\Collection;
use Orbt\ResourceMirror\Resource\LocalResource;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Orbt\ResourceMirror\ResourceMirror;

class AggregatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * An aggregator can be instantiated.
     */
    public function testCreate()
    {
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', sys_get_temp_dir());
        $aggregate = new Aggregator($mirror);
        $this->assertInstanceOf('Orbt\StyleMirror\Css\Aggregator', $aggregate);
    }

    /**
     * An aggregator aggregates a collection of resources into a single local resource.
     *
     * @depends testCreate
     */
    public function testAggregate()
    {
        while (file_exists($directory = sys_get_temp_dir().'/'.uniqid()));
        mkdir($directory);
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', $directory);

        $collection = new Collection();
        $collection->add($mirror->store(new LocalResource('a.css', 'css')));
        $collection->add($mirror->store(new LocalResource('b.css', 'css')));

        $aggregator = new Aggregator($mirror);
        $resource = $aggregator->aggregate($collection);
        $this->assertInstanceOf('Orbt\ResourceMirror\Resource\LocalResource', $resource);
        $this->assertEquals('csscss', $resource->getContent());
    }
}
