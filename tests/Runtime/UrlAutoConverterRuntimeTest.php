<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Tests\Runtime;

use Nucleos\Twig\Runtime\UrlAutoConverterRuntime;
use PHPUnit\Framework\TestCase;

final class UrlAutoConverterRuntimeTest extends TestCase
{
    public function testConvertLinksWithPlanText(): void
    {
        $extension = new UrlAutoConverterRuntime();

        self::assertSame('Lorem Ipsum test.de Sit Amet', $extension->convertLinks('Lorem Ipsum test.de Sit Amet'));
    }

    /**
     * @dataProvider getLinkText
     */
    public function testConvertLinksWithLinks(string $input, string $output): void
    {
        $extension = new UrlAutoConverterRuntime();

        self::assertSame($output, $extension->convertLinks($input));
    }

    /**
     * @dataProvider getMailText
     */
    public function testConvertLinksWithMails(string $input, string $output): void
    {
        $extension = new UrlAutoConverterRuntime();

        self::assertSame($output, $extension->convertLinks($input));
    }

    /**
     * @dataProvider getLinkTargetText
     */
    public function testConvertLinksWithOptions(string $input, string $output): void
    {
        $extension = new UrlAutoConverterRuntime();

        self::assertSame($output, $extension->convertLinks($input, ['target' => '_blank']));
    }

    public static function getLinkText(): iterable
    {
        // @noinspection JSUnusedLocalSymbols
        return [
            [
                'Lorem Ipsum http://test.de Sit Amet',
                'Lorem Ipsum <a href="http://test.de">http://test.de</a> Sit Amet',
            ],
            [
                'Lorem Ipsum <a href="http://test.de">http://test.de</a> Sit Amet',
                'Lorem Ipsum <a href="http://test.de">http://test.de</a> Sit Amet',
            ],
            [
                'Lorem Ipsum www.test.de/foo Sit Amet',
                'Lorem Ipsum <a href="http://www.test.de/foo">www.test.de/foo</a> Sit Amet',
            ],
            [
                'Lorem Ipsum www.test.de/foo/bar.html Sit Amet',
                'Lorem Ipsum <a href="http://www.test.de/foo/bar.html">www.test.de/foo/bar.html</a> Sit Amet',
            ],
            [
                'Lorem Ipsum <script>const link = "http://test.de"; </script> Sit Amet',
                'Lorem Ipsum <script>const link = "http://test.de"; </script> Sit Amet',
            ],
            [
                'Lorem Ipsum <script>const link = "www.test.de"; </script> Sit Amet',
                'Lorem Ipsum <script>const link = "www.test.de"; </script> Sit Amet',
            ],
        ];
    }

    /**
     * @return string[][]
     */
    public static function getLinkTargetText(): iterable
    {
        // @noinspection JSUnusedLocalSymbols
        return [
            [
                'Lorem Ipsum http://test.de Sit Amet',
                'Lorem Ipsum <a href="http://test.de" target="_blank">http://test.de</a> Sit Amet',
            ],
            [
                'Lorem Ipsum www.test.de/foo Sit Amet',
                'Lorem Ipsum <a href="http://www.test.de/foo" target="_blank">www.test.de/foo</a> Sit Amet',
            ],
            [
                'Lorem Ipsum www.test.de/foo/bar.html Sit Amet',
                'Lorem Ipsum <a href="http://www.test.de/foo/bar.html" target="_blank">www.test.de/foo/bar.html</a> Sit Amet',
            ],
        ];
    }

    /**
     * @return string[][]
     */
    public static function getMailText(): iterable
    {
        // @noinspection JSUnusedLocalSymbols
        return [
            [
                'Lorem Ipsum foo.sub@bar.baz.tld Sit Amet',
                'Lorem Ipsum <a href="mailto:foo.sub@bar.baz.tld">foo.sub@bar.baz.tld</a> Sit Amet',
            ],
            [
                'Lorem Ipsum <a href="mailto:foo.sub@bar.baz.tld">foo.sub@bar.baz.tld</a> Sit Amet',
                'Lorem Ipsum <a href="mailto:foo.sub@bar.baz.tld">foo.sub@bar.baz.tld</a> Sit Amet',
            ],
            [
                'Lorem Ipsum <script>const link = "foo@bar.baz"; </script> Sit Amet',
                'Lorem Ipsum <script>const link = "foo@bar.baz"; </script> Sit Amet',
            ],
        ];
    }
}
