<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\Twig\Tests\Util;

use Core23\Twig\Util\StringUtils;
use PHPUnit\Framework\TestCase;

final class StringUtilsTest extends TestCase
{
    /**
     * @dataProvider getObfuscatedStrings
     */
    public function testObfuscate(string $input, int $start, int $end, string $replacement, string $output): void
    {
        static::assertSame($output, StringUtils::obfuscate($input, $start, $end, $replacement));
    }

    public function getObfuscatedStrings(): iterable
    {
        return [
            ['Foo Bar Baz', 'start' => -3, 'end' => 1, 'replacement' => ' ', 'Foo Bar   z'],
            ['Foo Bar Baz', 'start' => 1, 'end' => 1, 'replacement' => ' ', 'F         z'],
            ['Foo Bar Baz', 'start' => 1, 'end' => 1, 'replacement' => '#', 'F#########z'],
            ['Foo Bar Baz', 'start' => 0, 'end' => 3, 'replacement' => '#', '########Baz'],
            ['Foo Bar Baz', 'start' => 2, 'end' => 0, 'replacement' => '#', 'Fo#########'],
            ['Foobar', 'start' => 1, 'end' => -3, 'replacement' => '#', 'F##bar'],
            ['Foobar', 'start' => 5, 'end' => 0, 'replacement' => '#', 'Foobar'],
            ['Foobar', 'start' => 6, 'end' => 0, 'replacement' => '#', 'Foobar'],
            ['Foobar', 'start' => 4, 'end' => 2, 'replacement' => '#', 'Foobar'],
            ['Foobar', 'start' => 4, 'end' => 3, 'replacement' => '#', 'Foobar'],
            ['Foobar', 'start' => 0, 'end' => 5, 'replacement' => '#', 'Foobar'],
            ['Foobar', 'start' => 0, 'end' => 6, 'replacement' => '#', 'Foobar'],
        ];
    }
}
