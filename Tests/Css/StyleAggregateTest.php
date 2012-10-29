<?php

namespace Orbt\StyleMirror\Tests\Css;

use Orbt\StyleMirror\Css\StyleAggregate;
use Orbt\ResourceMirror\Resource\LocalResource;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Orbt\ResourceMirror\ResourceMirror;

class StyleAggregateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A style aggregate can be instantiated.
     */
    public function testCreate()
    {
        $aggregate = new StyleAggregate();
        $this->assertInstanceOf('Orbt\StyleMirror\Css\StyleAggregate', $aggregate);
    }

    /**
     * A style aggregate compiles multiple style sheets into one style sheet.
     *
     * @depends testCreate
     */
    public function testAggregate()
    {
        while (file_exists($directory = sys_get_temp_dir().'/'.uniqid()));
        mkdir($directory);
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', $directory);
        $aggregate = new StyleAggregate();

        // Create resources to test. These are not actual CSS, but merely for asserting.
        $aggregate->addStyle($mirror->store(new LocalResource('a/style.css', '
            a:url(a/first.png);
        ')), 'all');
        $aggregate->addStyle($mirror->store(new LocalResource('b/style.css', '
            @import url(second.css);
            b:url(../B/second.png);
        ')), 'screen and handheld');
        $aggregate->addStyle($mirror->store(new LocalResource('c/d/style.css', '
            @import url(third.css);
            @media print {
              c:url(../D/third.png);
            }
        ')), 'print');

        // Aggregate and match.
        $content = $aggregate->getAggregateStyle();
        $this->assertRegExp('/^\s*(@import[^;]+;\s*){2}/', $content, 'Imports have been moved to the start.');
        $this->assertNotRegExp('/@media\s+all\s*\{\s*a:url/', $content, 'Media "all" is not wrapped.');
        $this->assertRegExp('/@media\s+screen\s+and\s+handheld\s*\{\s*b:url/', $content, 'Media "screen and handheld" is wrapped.');
        $this->assertNotRegExp('/@media\s+print\s*\{\s*@media\s+print\s*\{\s*c:url/', $content, 'Media rule is not nested.');
        $this->assertRegExp('!a:url\(\'a/a/first.png\'\)!', $content);
        $this->assertRegExp('!b:url\(\'B/second.png\'\)!', $content);
        $this->assertRegExp('!c:url\(\'c/D/third.png\'\)!', $content);
    }
}
