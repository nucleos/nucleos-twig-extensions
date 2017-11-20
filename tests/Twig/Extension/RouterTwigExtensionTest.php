<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Tests\Twig\Extension;

use Core23\TwigExtensions\Twig\Extension\RouterTwigExtension;
use PHPUnit\Framework\TestCase;
use Sonata\DatagridBundle\Pager\BasePager;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class RouterTwigExtensionTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RouterInterface
     */
    private $router;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Environment
     */
    private $environment;

    /**
     * @var RouterTwigExtension
     */
    private $extension;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->router      = $this->createMock(RouterInterface::class);
        $this->environment = $this->createMock(Environment::class);

        $this->extension = new RouterTwigExtension(
            $this->router, array(
                'template'     => 'template.html.twig',
                'extremeLimit' => 10,
                'nearbyLimit'  => 2,
            )
        );
        $this->extension->initRuntime($this->environment);
    }

    public function testRouteExists()
    {
        $route = $this->createMock(Route::class);

        $routeCollection = $this->createMock(RouteCollection::class);
        $routeCollection->expects($this->at(0))->method('get')->with($this->equalTo('foo'))->will($this->returnValue($route));
        $routeCollection->expects($this->at(1))->method('get')->with($this->equalTo('bar'))->will($this->returnValue(null));

        $this->router->expects($this->any())->method('getRouteCollection')->will($this->returnValue($routeCollection));

        $this->assertTrue($this->extension->routeExists('foo'));
        $this->assertFalse($this->extension->routeExists('bar'));
    }

    /**
     * @dataProvider getSplitList
     *
     * @param string $input
     * @param string $tag
     * @param array  $output
     */
    public function testSplitTag($input, $tag, array $output)
    {
        $this->assertSame($output, $this->extension->splitTag($input, $tag));
    }

    /**
     * @return array
     */
    public function getSplitList()
    {
        return array(
            array('<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'h1', array('<h1>Foo</h1><p>Bar</p>', '<h1>Baz</h1>Bar')),
            array('<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', '', array('<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar')),
            array('<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'img', array('<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar')),
            array('<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'h2', array('<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar')),
            array('<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'p', array('<h1>Foo</h1>', '<p>Bar</p><h1>Baz</h1>Bar')),
        );
    }

    public function testGeneratePager()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|BasePager $pager */
        $pager = $this->createMock(BasePager::class);
        $pager->expects($this->any())->method('count')->will($this->returnValue('100'));
        $pager->expects($this->any())->method('getMaxPerPage')->will($this->returnValue('20'));
        $pager->expects($this->any())->method('getPage')->will($this->returnValue('2'));

        $expectedData = array(
            'template'     => 'pager.html.twig',
            'extremeLimit' => 10,
            'nearbyLimit'  => 2,
            'itemsCount'   => 100,
            'limit'        => 20,
            'currentPage'  => 2,
            'lastPage'     => 5,
        );

        $this->environment->expects($this->once())->method('render')
            ->with($this->equalTo('pager.html.twig'), $this->equalTo($expectedData))
            ->willReturn('Pager Content');

        $this->extension->generatePager($pager, array('template' => 'pager.html.twig'));
    }
}
