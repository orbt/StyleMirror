<?php

namespace Orbt\StyleMirror\Tests\Resource;

use Orbt\StyleMirror\Resource\SingleUseQueue;
use Orbt\ResourceMirror\Resource\GenericResource;

class SingleUseQueueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A single use queue can be instantiated.
     */
    public function testCreate()
    {
        $queue = new SingleUseQueue();
        $this->assertInstanceOf('Orbt\StyleMirror\Resource\SingleUseQueue', $queue);
    }

    /**
     * A new single use queue flushes an empty collection.
     *
     * @depends testCreate
     */
    public function testFlush()
    {
        $queue = new SingleUseQueue();
        $this->assertEmpty($queue->flush()->getAll());
    }

    /**
     * A resource is added to a single use queue.
     *
     * @depends testFlush
     */
    public function testAdd()
    {
        $queue = new SingleUseQueue();
        $queue->add(new GenericResource('test'));
        $resources = $queue->flush()->getAll();
        $this->assertInstanceOf('Orbt\ResourceMirror\Resource\Resource', reset($resources));
        $this->assertEmpty($queue->flush()->getAll());
    }

    /**
     * Only one resource with a given path is added once to a single use queue.
     *
     * @depends testFlush
     */
    public function testAddOnce()
    {
        $queue = new SingleUseQueue();
        $queue->add(new GenericResource('test'));
        $queue->add(new GenericResource('test'));
        $this->assertCount(1, $queue->flush()->getAll());
        $queue->add(new GenericResource('test'));
        $this->assertEmpty($queue->flush()->getAll());
    }
}
