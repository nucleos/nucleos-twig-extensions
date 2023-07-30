<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Tests\Extension;

use Nucleos\Twig\Extension\StringExtension;
use PHPUnit\Framework\TestCase;
use Twig\TwigFilter;

final class StringExtensionTest extends TestCase
{
    private StringExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new StringExtension();
    }

    public function testGetFilters(): void
    {
        $filters = $this->extension->getFilters();

        foreach ($filters as $filter) {
            self::assertCallable($filter->getCallable());
        }

        self::assertSame(
            [
                'format_bytes',
                'obfuscate',
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
