<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Tests\Twig\Extension;

use Core23\TwigExtensions\Twig\Extension\UrlAutoConverterTwigExtension;
use PHPUnit\Framework\TestCase;

final class UrlAutoConverterTwigExtensionTest extends TestCase
{
    public function testConvertLinksWithPlanText(): void
    {
        $extension = new UrlAutoConverterTwigExtension();

        $this->assertSame('Lorem Ipsum test.de Sit Amet', $extension->convertLinks('Lorem Ipsum test.de Sit Amet'));
    }

    /**
     * @dataProvider getLinkText
     *
     * @param string $input
     * @param string $output
     */
    public function testConvertLinksWithLinks(string $input, string $output): void
    {
        $extension = new UrlAutoConverterTwigExtension();

        $this->assertSame($output, $extension->convertLinks($input));
    }

    /**
     * @dataProvider getMailText
     *
     * @param string $input
     * @param string $output
     */
    public function testConvertLinksWithMails(string $input, string $output): void
    {
        $extension = new UrlAutoConverterTwigExtension();

        $this->assertSame($output, $extension->convertLinks($input));
    }

    /**
     * @return array
     */
    public function getLinkText()
    {
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
                'Lorem Ipsum <script>var link = "http://test.de"; </script> Sit Amet',
                'Lorem Ipsum <script>var link = "http://test.de"; </script> Sit Amet',
            ],
            [
                'Lorem Ipsum <script>var link = "www.test.de"; </script> Sit Amet',
                'Lorem Ipsum <script>var link = "www.test.de"; </script> Sit Amet',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getMailText()
    {
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
                'Lorem Ipsum <script>var link = "foo@bar.baz"; </script> Sit Amet',
                'Lorem Ipsum <script>var link = "foo@bar.baz"; </script> Sit Amet',
            ],
        ];
    }
}
