<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Tests\Runtime;

use Locale;
use Nucleos\Twig\Runtime\StringRuntime;
use PHPUnit\Framework\TestCase;

final class StringRuntimeTest extends TestCase
{
    protected function setUp(): void
    {
        Locale::setDefault('de-DE');
    }

    /**
     * @dataProvider getBase10
     *
     * @param float|int $bits
     */
    public function testFormatBytesBase10(string $expected, $bits): void
    {
        $extension = new StringRuntime();

        self::assertSame(
            $expected,
            $extension->formatBytes($bits, true, 1)
        );
    }

    /**
     * @dataProvider getBase2
     *
     * @param float|int $bits
     */
    public function testFormatBytesBase2(string $expected, $bits): void
    {
        $extension = new StringRuntime();

        self::assertSame(
            $expected,
            $extension->formatBytes($bits, false, 1)
        );
    }

    /**
     * @return int[][]|string[][]
     */
    public static function getBase10(): iterable
    {
        return [
            ['500,0 B', 500],
            ['1,0 kB', 1000],
            ['1,5 kB', 1500],
            ['2,0 kB', 2000],
            ['1,0 MB', 1000 ** 2],
            ['1,0 GB', 1000 ** 3],
            ['1,0 TB', 1000 ** 4],
            ['1,0 PB', 1000 ** 5],
            ['1,0 EB', 1000 ** 6],
        ];
    }

    /**
     * @return int[][]|string[][]
     */
    public static function getBase2(): iterable
    {
        return [
            ['512,0 B', 512],
            ['1,0 KiB', 1024],
            ['1,5 KiB', 1536],
            ['2,0 KiB', 2048],
            ['1,0 MiB', 1024 ** 2],
            ['1,0 GiB', 1024 ** 3],
            ['1,0 TiB', 1024 ** 4],
            ['1,0 PiB', 1024 ** 5],
            ['1,0 EiB', 1024 ** 6],
        ];
    }

    public function testObfuscate(): void
    {
        $extension = new StringRuntime();

        self::assertSame('T***', $extension->obfuscate(
            'Test',
            [
                'start'       => 1,
                'end'         => 0,
                'replacement' => '*',
            ]
        ));
    }
}
