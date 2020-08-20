<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Tests\Twig\Extension;

use Nucleos\Twig\Extension\RouterTwigExtension;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sonata\DatagridBundle\Pager\BasePager;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class RouterTwigExtensionTest extends TestCase
{
    /**
     * @var MockObject&RouterInterface
     */
    private $router;

    /**
     * @var MockObject&Environment
     */
    private $environment;

    /**
     * @var RouterTwigExtension
     */
    private $extension;

    protected function setUp(): void
    {
        $router      = $this->createMock(RouterInterface::class);
        $environment = $this->createMock(Environment::class);

        $this->router      = $router;
        $this->environment = $environment;

        $this->extension = new RouterTwigExtension($this->environment, $router, [
            'template'     => 'template.html.twig',
            'extremeLimit' => 10,
            'nearbyLimit'  => 2,
        ]);
    }

    public function testItIsNotInstantiableWithMissingTemplate(): void
    {
        $this->expectException(LoaderError::class);
        $this->expectExceptionMessage('Pager template is not set.');

        $this->extension = new RouterTwigExtension($this->environment, $this->router, [
            'extremeLimit' => 10,
            'nearbyLimit'  => 2,
        ]);
    }

    public function testItIsNotInstantiableWithMissingExtremeLimit(): void
    {
        $this->expectException(LoaderError::class);
        $this->expectExceptionMessage('Pager extreme limit is not set.');

        $this->extension = new RouterTwigExtension($this->environment, $this->router, [
            'template'     => 'template.html.twig',
            'nearbyLimit'  => 2,
        ]);
    }

    public function testItIsNotInstantiableWithMissingNearbyLimit(): void
    {
        $this->expectException(LoaderError::class);
        $this->expectExceptionMessage('Pager nearby limit is not set.');

        $this->extension = new RouterTwigExtension($this->environment, $this->router, [
            'template'     => 'template.html.twig',
            'extremeLimit' => 10,
        ]);
    }

    public function testGetFilters(): void
    {
        $filters = $this->extension->getFilters();

        static::assertNotCount(0, $filters);

        foreach ($filters as $filter) {
            static::assertInstanceOf(TwigFilter::class, $filter);
            static::assertIsCallable($filter->getCallable());
        }
    }

    public function testGetFunctions(): void
    {
        $filters = $this->extension->getFunctions();

        static::assertNotCount(0, $filters);

        foreach ($filters as $filter) {
            static::assertInstanceOf(TwigFunction::class, $filter);
            static::assertIsCallable($filter->getCallable());
        }
    }

    public function testRouteExists(): void
    {
        $route = $this->createMock(Route::class);

        $routeCollection = $this->createMock(RouteCollection::class);
        $routeCollection->expects(static::exactly(2))->method('get')
            ->withConsecutive(
                [static::equalTo('foo')],
                [static::equalTo('bar')]
            )
            ->willReturn(
                $route,
                null
            )
        ;

        $this->router->method('getRouteCollection')->willReturn($routeCollection);

        static::assertTrue($this->extension->routeExists('foo'));
        static::assertFalse($this->extension->routeExists('bar'));
    }

    /**
     * @dataProvider getSplitList
     */
    public function testSplitTag(string $input, string $tag, array $output): void
    {
        static::assertSame($output, $this->extension->splitTag($input, $tag));
    }

    public function getSplitList(): iterable
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
        $pager->method('count')->willReturn(100);
        $pager->method('getMaxPerPage')->willReturn(20);
        $pager->method('getPage')->willReturn(2);

        $expectedData = [
            'template'     => 'pager.html.twig',
            'extremeLimit' => 10,
            'nearbyLimit'  => 2,
            'itemsCount'   => 100,
            'limit'        => 20,
            'currentPage'  => 2,
            'lastPage'     => 5,
        ];

        $this->environment->expects(static::once())->method('render')
            ->with(static::equalTo('pager.html.twig'), static::equalTo($expectedData))
            ->willReturn('Pager Content')
        ;

        $this->extension->generatePager($pager, ['template' => 'pager.html.twig']);
    }

    public function testGeneratePagerWithNegativeLimit(): void
    {
        $pager = $this->createMock(BasePager::class);
        $pager->method('count')->willReturn(100);
        $pager->method('getMaxPerPage')->willReturn(-1);
        $pager->method('getPage')->willReturn(2);

        $expectedData = [
            'template'     => 'pager.html.twig',
            'extremeLimit' => 10,
            'nearbyLimit'  => 2,
            'itemsCount'   => 100,
            'limit'        => 1,
            'currentPage'  => 2,
            'lastPage'     => 100,
        ];

        $this->environment->expects(static::once())->method('render')
            ->with(static::equalTo('pager.html.twig'), static::equalTo($expectedData))
            ->willReturn('Pager Content')
        ;

        $this->extension->generatePager($pager, [
            'template' => 'pager.html.twig',
        ]);
    }
}
