<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Tests\Twig\Extension;

use Core23\TwigExtensions\Twig\Extension\UrlAutoConverterTwigExtension;
use PHPUnit\Framework\TestCase;

class UrlAutoConverterTwigExtensionTest extends TestCase
{
    public function testAutoConvertUrlsWithPlanText()
    {
        $extension = new UrlAutoConverterTwigExtension(false, '[DOT]', 'spam', '[AT]');

        $this->assertSame('Lorem Ipsum test.de Sit Amet', $extension->autoConvertUrls('Lorem Ipsum test.de Sit Amet'));
    }

    /**
     * @dataProvider getLinkText
     *
     * @param $input
     * @param $output
     */
    public function testAutoConvertUrlsWithLinks($input, $output)
    {
        $extension = new UrlAutoConverterTwigExtension(true, '[DOT]', 'spam', '[AT]');

        $this->assertSame($output, $extension->autoConvertUrls($input));
    }

    /**
     * @dataProvider getMailText
     *
     * @param $input
     * @param $output
     */
    public function testAutoConvertUrlsWithMails($input, $output)
    {
        $extension = new UrlAutoConverterTwigExtension(false, '[DOT]', 'spam', '[AT]');

        $this->assertSame($output, $extension->autoConvertUrls($input));
    }

    /**
     * @dataProvider getSecureMailText
     *
     * @param $input
     * @param $output
     */
    public function testAutoConvertUrlsWithSecureMails($input, $output)
    {
        $extension = new UrlAutoConverterTwigExtension(true, '[DOT]', 'spam', '[AT]');

        $this->assertSame($output, $extension->autoConvertUrls($input));
    }

    /**
     * @return array
     */
    public function getLinkText()
    {
        return array(
            array(
                'Lorem Ipsum http://test.de Sit Amet',
                'Lorem Ipsum <a href="http://test.de">http://test.de</a> Sit Amet',
            ),
            array(
                'Lorem Ipsum <a href="http://test.de">http://test.de</a> Sit Amet',
                'Lorem Ipsum <a href="http://test.de">http://test.de</a> Sit Amet',
            ),
            array(
                'Lorem Ipsum www.test.de/foo Sit Amet',
                'Lorem Ipsum <a href="http://www.test.de/foo">www.test.de/foo</a> Sit Amet',
            ),
            array(
                'Lorem Ipsum www.test.de/foo/bar.html Sit Amet',
                'Lorem Ipsum <a href="http://www.test.de/foo/bar.html">www.test.de/foo/bar.html</a> Sit Amet',
            ),
            array(
                'Lorem Ipsum <script>var link = "http://test.de"; </script> Sit Amet',
                'Lorem Ipsum <script>var link = "http://test.de"; </script> Sit Amet',
            ),
            array(
                'Lorem Ipsum <script>var link = "www.test.de"; </script> Sit Amet',
                'Lorem Ipsum <script>var link = "www.test.de"; </script> Sit Amet',
            ),
        );
    }

    /**
     * @return array
     */
    public function getMailText()
    {
        return array(
            array(
                'Lorem Ipsum foo.sub@bar.baz.tld Sit Amet',
                'Lorem Ipsum <a href="mailto:foo.sub@bar.baz.tld">foo.sub@bar.baz.tld</a> Sit Amet',
            ),
            array(
                'Lorem Ipsum <a href="mailto:foo.sub@bar.baz.tld">foo.sub@bar.baz.tld</a> Sit Amet',
                'Lorem Ipsum <a href="mailto:foo.sub@bar.baz.tld">foo.sub@bar.baz.tld</a> Sit Amet',
            ),
            array(
                'Lorem Ipsum <script>var link = "foo@bar.baz"; </script> Sit Amet',
                'Lorem Ipsum <script>var link = "foo@bar.baz"; </script> Sit Amet',
            ),
        );
    }

    /**
     * @return array
     */
    public function getSecureMailText()
    {
        return array(
            array(
                'Lorem Ipsum <script>var link = "foo@bar.baz"; </script> Sit Amet',
                'Lorem Ipsum <script>var link = "foo@bar.baz"; </script> Sit Amet',
            ),
            array(
                'Lorem Ipsum foo.sub@bar.baz.tld Sit Amet',
                'Lorem Ipsum <span class="spam"><span>foo[DOT]sub</span>[AT]<span>bar[DOT]baz[DOT]tld</span></span> Sit Amet',
            ),
            array(
                'Lorem Ipsum <span class="spam"><span>foo[DOT]sub</span>[AT]<span>bar[DOT]baz[DOT]tld</span></span> Sit Amet',
                'Lorem Ipsum <span class="spam"><span>foo[DOT]sub</span>[AT]<span>bar[DOT]baz[DOT]tld</span></span> Sit Amet',
            ),
        );
    }
}
