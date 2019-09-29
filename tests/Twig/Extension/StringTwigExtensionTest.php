<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\Twig\Tests\Twig\Extension;

use Core23\Twig\Extension\StringTwigExtension;
use PHPUnit\Framework\TestCase;
use Sonata\IntlBundle\Templating\Helper\NumberHelper;
use Twig\TwigFilter;

final class StringTwigExtensionTest extends TestCase
{
    private $numberHelper;

    protected function setUp(): void
    {
        $this->numberHelper = $this->createMock(NumberHelper::class);
    }

    public function testGetFilters(): void
    {
        $extension = new StringTwigExtension($this->numberHelper);

        $filters = $extension->getFilters();

        static::assertNotCount(0, $filters);

        foreach ($filters as $filter) {
            static::assertInstanceOf(TwigFilter::class, $filter);
            static::assertIsCallable($filter->getCallable());
        }
    }

    /**
     * @dataProvider getBase10
     *
     * @param float|int $bits
     * @param float|int $number
     */
    public function testFormatBytesBase10($bits, $number, string $unit): void
    {
        $extension = new StringTwigExtension($this->numberHelper);

        $this->numberHelper->expects(static::once())->method('formatDecimal')
            ->with(static::equalTo($number), static::equalTo(['fraction_digits' => 1]))
            ->willReturn($number)
        ;

        static::assertStringEndsWith($unit, $extension->formatBytes($bits, true, 1));
    }

    /**
     * @dataProvider getBase2
     *
     * @param float|int $bits
     * @param float|int $number
     */
    public function testFormatBytesBase2($bits, $number, string $unit): void
    {
        $extension = new StringTwigExtension($this->numberHelper);

        $this->numberHelper->expects(static::once())->method('formatDecimal')
            ->with(static::equalTo($number), static::equalTo(['fraction_digits' => 1]))
            ->willReturn($number)
        ;

        static::assertStringEndsWith($unit, $extension->formatBytes($bits, false, 1));
    }

    public function getBase10(): iterable
    {
        return [
            [500, 500, 'B'],
            [1000, 1, 'kB'],
            [1500, 1.5, 'kB'],
            [2000, 2, 'kB'],
            [1000 ** 2, 1, 'MB'],
            [1000 ** 3, 1, 'GB'],
            [1000 ** 4, 1, 'TB'],
            [1000 ** 5, 1, 'PB'],
            [1000 ** 6, 1, 'EB'],
        ];
    }

    public function getBase2(): iterable
    {
        return [
            [512, 512, 'B'],
            [1024, 1, 'KiB'],
            [1536, 1.5, 'KiB'],
            [2048, 2, 'KiB'],
            [1024 ** 2, 1, 'MiB'],
            [1024 ** 3, 1, 'GiB'],
            [1024 ** 4, 1, 'TiB'],
            [1024 ** 5, 1, 'PiB'],
            [1024 ** 6, 1, 'EiB'],
        ];
    }

    public function testObfuscate(): void
    {
        $extension = new StringTwigExtension($this->numberHelper);

        static::assertSame('T***', $extension->obfuscate(
            'Test',
            [
                'start'       => 1,
                'end'         => 0,
                'replacement' => '*',
            ]
        ));
    }
}
