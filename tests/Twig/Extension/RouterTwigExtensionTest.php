<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\Twig\Tests\Twig\Extension;

use Core23\Twig\Extension\RouterTwigExtension;
use PHPUnit\Framework\TestCase;
use Sonata\DatagridBundle\Pager\BasePager;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

final class RouterTwigExtensionTest extends TestCase
{
    private $router;

    private $environment;

    /**
     * @var RouterTwigExtension
     */
    private $extension;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->router      = $this->createMock(RouterInterface::class);
        $this->environment = $this->createMock(Environment::class);

        $this->extension = new RouterTwigExtension(
            $this->router, [
                'template'     => 'template.html.twig',
                'extremeLimit' => 10,
                'nearbyLimit'  => 2,
            ]
        );
        $this->extension->initRuntime($this->environment);
    }

    public function testRouteExists(): void
    {
        $route = $this->createMock(Route::class);

        $routeCollection = $this->createMock(RouteCollection::class);
        $routeCollection->expects($this->at(0))->method('get')->with($this->equalTo('foo'))->will($this->returnValue($route));
        $routeCollection->expects($this->at(1))->method('get')->with($this->equalTo('bar'))->will($this->returnValue(null));

        $this->router->method('getRouteCollection')->will($this->returnValue($routeCollection));

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
    public function testSplitTag(string $input, string $tag, array $output): void
    {
        $this->assertSame($output, $this->extension->splitTag($input, $tag));
    }

    /**
     * @return array
     */
    public function getSplitList(): array
    {
        return [
            ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'h1', ['<h1>Foo</h1><p>Bar</p>', '<h1>Baz</h1>Bar']],
            ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', '', ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar']],
            ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'img', ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar']],
            ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'h2', ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar']],
            ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'p', ['<h1>Foo</h1>', '<p>Bar</p><h1>Baz</h1>Bar']],
        ];
    }

    public function testGeneratePager(): void
    {
        $pager = $this->createMock(BasePager::class);
        $pager->method('count')->will($this->returnValue('100'));
        $pager->method('getMaxPerPage')->will($this->returnValue('20'));
        $pager->method('getPage')->will($this->returnValue('2'));

        $expectedData = [
            'template'     => 'pager.html.twig',
            'extremeLimit' => 10,
            'nearbyLimit'  => 2,
            'itemsCount'   => 100,
            'limit'        => 20,
            'currentPage'  => 2,
            'lastPage'     => 5,
        ];

        $this->environment->expects($this->once())->method('render')
            ->with($this->equalTo('pager.html.twig'), $this->equalTo($expectedData))
            ->willReturn('Pager Content');

        $this->extension->generatePager($pager, ['template' => 'pager.html.twig']);
    }
}
