<?php

namespace Orbt\StyleMirror\Tests;

use Orbt\StyleMirror\Css\ResourceScanner;
use Orbt\ResourceMirror\Resource\GenericResource;
use Orbt\StyleMirror\Resource\SingleUseQueue;

class ResourceScannerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A resource scanner can be instantiated.
     */
    public function testCreate()
    {
        $scanner = new ResourceScanner(new SingleUseQueue());
        $this->assertInstanceOf('Orbt\StyleMirror\Css\ResourceScanner', $scanner);
    }

    /**
     * A resource scanner returns its scanner queue.
     *
     * @depends testCreate
     */
    public function testGetQueue()
    {
        $scanner = new ResourceScanner($queue = new SingleUseQueue());
        $this->assertTrue($queue === $scanner->getQueue());
    }

    /**
     * A resource scanner scans CSS for linked resources.
     *
     * @depends testCreate
     */
    public function testScan()
    {
        $scanner = new ResourceScanner($queue = new SingleUseQueue());
        $content = <<<EOF
            /* These should be matched. */
            url(one);
            url('two');
            url("three");
            /* These should be resolve automatically. */
            url(../four/test);
            url(../../five);
            /* These should be ignored. */
            url(http://six);
            url(/seven);
            url(:);
            url(/);
            url(../../../../eight);
EOF;
        $scanner->scan(new GenericResource('base/folder/style.css'), $content);
        $expected = array(
            'base/folder/one',
            'base/folder/two',
            'base/folder/three',
            'base/four/test',
            'five',
        );
        $result = array();
        foreach ($queue->flush()->getAll() as $resource) {
            $result[] = $resource->getPath();
        }
        $this->assertEquals($expected, $result);
    }
}
