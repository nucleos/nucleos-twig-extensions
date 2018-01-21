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
    public function testAutoConvertUrlsWithPlanText(): void
    {
        $extension = new UrlAutoConverterTwigExtension(false, '[DOT]', 'spam', '[AT]');

        $this->assertSame('Lorem Ipsum test.de Sit Amet', $extension->autoConvertUrls('Lorem Ipsum test.de Sit Amet'));
    }

    /**
     * @dataProvider getLinkText
     *
     * @param string $input
     * @param string $output
     */
    public function testAutoConvertUrlsWithLinks(string $input, string $output): void
    {
        $extension = new UrlAutoConverterTwigExtension(true, '[DOT]', 'spam', '[AT]');

        $this->assertSame($output, $extension->autoConvertUrls($input));
    }

    /**
     * @dataProvider getMailText
     *
     * @param string $input
     * @param string $output
     */
    public function testAutoConvertUrlsWithMails(string $input, string $output): void
    {
        $extension = new UrlAutoConverterTwigExtension(false, '[DOT]', 'spam', '[AT]');

        $this->assertSame($output, $extension->autoConvertUrls($input));
    }

    /**
     * @dataProvider getSecureMailText
     *
     * @param string $input
     * @param string $output
     */
    public function testAutoConvertUrlsWithSecureMails(string $input, string $output): void
    {
        $extension = new UrlAutoConverterTwigExtension(true, '[DOT]', 'spam', '[AT]');

        $this->assertSame($output, $extension->autoConvertUrls($input));
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

    /**
     * @return array
     */
    public function getSecureMailText()
    {
        return [
            [
                'Lorem Ipsum <script>var link = "foo@bar.baz"; </script> Sit Amet',
                'Lorem Ipsum <script>var link = "foo@bar.baz"; </script> Sit Amet',
            ],
            [
                'Lorem Ipsum foo.sub@bar.baz.tld Sit Amet',
                'Lorem Ipsum <span class="spam"><span>foo[DOT]sub</span>[AT]<span>bar[DOT]baz[DOT]tld</span></span> Sit Amet',
            ],
            [
                'Lorem Ipsum <span class="spam"><span>foo[DOT]sub</span>[AT]<span>bar[DOT]baz[DOT]tld</span></span> Sit Amet',
                'Lorem Ipsum <span class="spam"><span>foo[DOT]sub</span>[AT]<span>bar[DOT]baz[DOT]tld</span></span> Sit Amet',
            ],
        ];
    }
}
