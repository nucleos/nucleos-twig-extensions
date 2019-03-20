<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\Twig\Tests\Twig\Extension;

use Core23\Twig\Extension\UrlAutoConverterTwigExtension;
use PHPUnit\Framework\TestCase;
use Twig\TwigFilter;

final class UrlAutoConverterTwigExtensionTest extends TestCase
{
    public function testGetFilters(): void
    {
        $extension = new UrlAutoConverterTwigExtension();

        $filters = $extension->getFilters();

        $this->assertNotCount(0, $filters);

        foreach ($filters as $filter) {
            $this->assertInstanceOf(TwigFilter::class, $filter);
            $this->assertIsCallable($filter->getCallable());
        }
    }

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
     * @dataProvider getLinkTargetText
     *
     * @param string $input
     * @param string $output
     */
    public function testConvertLinksWithOptions(string $input, string $output): void
    {
        $extension = new UrlAutoConverterTwigExtension();

        $this->assertSame($output, $extension->convertLinks($input, ['target' => '_blank']));
    }

    /**
     * @return array
     */
    public function getLinkText(): array
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
     * @return array
     */
    public function getLinkTargetText(): array
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
     * @return array
     */
    public function getMailText(): array
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
