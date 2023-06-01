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
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class RouterTwigExtensionTest extends TestCase
{
    /**
     * @var MockObject&RouterInterface
     */
    private RouterInterface $router;

    private RouterTwigExtension $extension;

    protected function setUp(): void
    {
        $this->router    = $this->createMock(RouterInterface::class);
        $this->extension = new RouterTwigExtension($this->router);
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
        $routeCollection = new RouteCollection();
        $routeCollection->add('foo', new Route('/foo'));

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

    public static function getSplitList(): iterable
    {
        return [
            ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'h1', ['<h1>Foo</h1><p>Bar</p>', '<h1>Baz</h1>Bar']],
            ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', '', ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar']],
            ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'img', ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar']],
            ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'h2', ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar']],
            ['<h1>Foo</h1><p>Bar</p><h1>Baz</h1>Bar', 'p', ['<h1>Foo</h1>', '<p>Bar</p><h1>Baz</h1>Bar']],
        ];
    }
}
