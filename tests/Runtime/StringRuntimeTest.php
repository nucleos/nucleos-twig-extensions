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
    private StringRuntime $runtime;

    protected function setUp(): void
    {
        Locale::setDefault('de-DE');

        $this->runtime = new StringRuntime([' [AT] ', ' [ÄT] ', ' (AT) ', ' |AT| '], [' [DOT] ', ' PUNKT ', '[.]']);
    }

    /**
     * @dataProvider provideFormatBytesBase10Cases
     *
     * @param float|int $bits
     */
    public function testFormatBytesBase10(string $expected, $bits): void
    {
        self::assertSame(
            $expected,
            $this->runtime->formatBytes($bits, true, 1)
        );
    }

    /**
     * @dataProvider provideFormatBytesBase2Cases
     *
     * @param float|int $bits
     */
    public function testFormatBytesBase2(string $expected, $bits): void
    {
        self::assertSame(
            $expected,
            $this->runtime->formatBytes($bits, false, 1)
        );
    }

    /**
     * @return int[][]|string[][]
     */
    public static function provideFormatBytesBase10Cases(): iterable
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
    public static function provideFormatBytesBase2Cases(): iterable
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

    /**
     * @dataProvider provideSpamSecureCases
     */
    public function testSpamSecure(string $input, string $output): void
    {
        self::assertSame($output, $this->runtime->spamsecure($input));
    }

    /**
     * @dataProvider provideSpamSecureTextCases
     */
    public function testSpamSecureText(string $input, string $output): void
    {
        self::assertSame($output, $this->runtime->spamsecure($input, false));
    }

    /**
     * @return string[][]
     */
    public static function provideSpamSecureCases(): iterable
    {
        return [
            [
                'Lorem Ipsum <script>const link = "foo@bar.baz"; </script> Sit Amet',
                'Lorem Ipsum <script>const link = "foo@bar.baz"; </script> Sit Amet',
            ],
            [
                'Lorem Ipsum <a href="mailto:john@smith.cool">John Smith</a> Sit Amet',
                'Lorem Ipsum john [AT] smith[.]cool (John Smith) Sit Amet',
            ],
            [
                'Lorem Ipsum <a href="mailto:foo.sub@bar.baz.tld">foo.sub@bar.baz.tld</a> Sit Amet',
                'Lorem Ipsum foo [DOT] sub (AT) bar PUNKT baz PUNKT tld Sit Amet',
            ],
            [
                'Lorem Ipsum foo [DOT] sub (AT) bar PUNKT baz PUNKT tld Sit Amet',
                'Lorem Ipsum foo [DOT] sub (AT) bar PUNKT baz PUNKT tld Sit Amet',
            ],
        ];
    }

    /**
     * @return string[][]
     */
    public static function provideSpamSecureTextCases(): iterable
    {
        return [
            [
                'Lorem Ipsum foo.sub@bar.baz.tld Sit Amet',
                'Lorem Ipsum foo [DOT] sub [AT] bar PUNKT baz PUNKT tld Sit Amet',
            ],
            [
                'Lorem Ipsum foo [DOT] sub [AT] bar PUNKT baz PUNKT tld Sit Amet',
                'Lorem Ipsum foo [DOT] sub [AT] bar PUNKT baz PUNKT tld Sit Amet',
            ],
            [
                'Lorem Ipsum foo[DOT]sub[AT]bar PUNKT baz PUNKT tld Sit Amet',
                'Lorem Ipsum foo[DOT]sub[AT]bar PUNKT baz PUNKT tld Sit Amet',
            ],
        ];
    }

    public function testObfuscate(): void
    {
        self::assertSame('T***', $this->runtime->obfuscate(
            'Test',
            [
                'start'       => 1,
                'end'         => 0,
                'replacement' => '*',
            ]
        ));
    }
}
