<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Tests\Twig\Extension;

use Core23\TwigExtensions\Twig\Extension\StringTwigExtension;
use PHPUnit\Framework\TestCase;
use Sonata\IntlBundle\Templating\Helper\NumberHelper;

final class StringTwigExtensionTest extends TestCase
{
    private $numberHelper;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->numberHelper = $this->createMock(NumberHelper::class);
    }

    /**
     * @dataProvider getBase10
     *
     * @param int|float $bits
     * @param int|float $number
     * @param string    $unit
     */
    public function testFormatBytesBase10($bits, $number, string $unit): void
    {
        $extension = new StringTwigExtension($this->numberHelper);

        $this->numberHelper->expects($this->once())->method('formatDecimal')
            ->with($this->equalTo($number), $this->equalTo(['fraction_digits' => 1]))
            ->will($this->returnValue($number));

        $this->assertStringEndsWith($unit, $extension->formatBytes($bits, true, 1));
    }

    /**
     * @dataProvider getBase2
     *
     * @param int|float $bits
     * @param int|float $number
     * @param string    $unit
     */
    public function testFormatBytesBase2($bits, $number, string $unit): void
    {
        $extension = new StringTwigExtension($this->numberHelper);

        $this->numberHelper->expects($this->once())->method('formatDecimal')
            ->with($this->equalTo($number), $this->equalTo(['fraction_digits' => 1]))
            ->will($this->returnValue($number));

        $this->assertStringEndsWith($unit, $extension->formatBytes($bits, false, 1));
    }

    /**
     * @return array
     */
    public function getBase10(): array
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

    /**
     * @return array
     */
    public function getBase2(): array
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

        $this->assertSame('T***', $extension->obfuscate(
            'Test',
            [
                'start'       => 1,
                'end'         => 0,
                'replacement' => '*',
            ]
        ));
    }
}
