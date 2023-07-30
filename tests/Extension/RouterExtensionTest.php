<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Tests\Extension;

use Nucleos\Twig\Extension\RouterExtension;
use PHPUnit\Framework\TestCase;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class RouterExtensionTest extends TestCase
{
    private RouterExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new RouterExtension();
    }

    public function testGetFunctions(): void
    {
        $functions = $this->extension->getFunctions();

        foreach ($functions as $function) {
            self::assertCallable($function->getCallable());
        }

        self::assertSame(
            [
                'routeExists',
            ],
            array_map(static fn (TwigFunction $function): string => $function->getName(), $functions)
        );
    }

    public function testGetFilters(): void
    {
        $filters = $this->extension->getFilters();

        foreach ($filters as $filter) {
            self::assertCallable($filter->getCallable());
        }

        self::assertSame(
            [
                'splitTag',
            ],
            array_map(static fn (TwigFilter $filter): string => $filter->getName(), $filters)
        );
    }

    private static function assertCallable(mixed $callable): void
    {
        if (\is_array($callable)) {
            self::assertTrue(method_exists($callable[0], $callable[1]));
        } else {
            self::assertIsCallable($callable);
        }
    }
}
