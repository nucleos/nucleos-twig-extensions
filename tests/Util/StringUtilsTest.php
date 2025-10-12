<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Tests\Util;

use Nucleos\Twig\Util\StringUtils;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class StringUtilsTest extends TestCase
{
    #[DataProvider('provideObfuscateCases')]
    public function testObfuscate(string $input, int $start, int $end, string $replacement, string $output): void
    {
        self::assertSame($output, StringUtils::obfuscate($input, $start, $end, $replacement));
    }

    public static function provideObfuscateCases(): iterable
    {
        return [
            ['Foo Bar Baz', -3, 1, ' ', 'Foo Bar   z'],
            ['Foo Bar Baz', 1, 1, ' ', 'F         z'],
            ['Foo Bar Baz', 1, 1, '#', 'F#########z'],
            ['Foo Bar Baz', 0, 3, '#', '########Baz'],
            ['Foo Bar Baz', 2, 0, '#', 'Fo#########'],
            ['Foobar', 1, -3, '#', 'F##bar'],
            ['Foobar', 5, 0, '#', 'Foobar'],
            ['Foobar', 6, 0, '#', 'Foobar'],
            ['Foobar', 4, 2, '#', 'Foobar'],
            ['Foobar', 4, 3, '#', 'Foobar'],
            ['Foobar', 0, 5, '#', 'Foobar'],
            ['Foobar', 0, 6, '#', 'Foobar'],
        ];
    }
}
