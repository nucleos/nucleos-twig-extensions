<?php

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

class StringTwigExtensionTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|NumberHelper
     */
    private $numberHelper;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->numberHelper = $this->createMock(NumberHelper::class);
    }

    /**
     * @dataProvider getBase10
     *
     * @param $bits
     * @param $number
     * @param $unit
     */
    public function testFormatBytesBase10($bits, $number, $unit)
    {
        $extension = new StringTwigExtension($this->numberHelper);

        $this->numberHelper->expects($this->once())->method('formatDecimal')
            ->with($this->equalTo($number), $this->equalTo(array('fraction_digits' => 1)))
            ->will($this->returnValue($number));

        $this->assertStringEndsWith($unit, $extension->formatBytes($bits, true, 1));
    }

    /**
     * @dataProvider getBase2
     *
     * @param $bits
     * @param $number
     * @param $unit
     */
    public function testFormatBytesBase2($bits, $number, $unit)
    {
        $extension = new StringTwigExtension($this->numberHelper);

        $this->numberHelper->expects($this->once())->method('formatDecimal')
            ->with($this->equalTo($number), $this->equalTo(array('fraction_digits' => 1)))
            ->will($this->returnValue($number));

        $this->assertStringEndsWith($unit, $extension->formatBytes($bits, false, 1));
    }

    /**
     * @return array
     */
    public function getBase10()
    {
        return array(
            array(500, 500, 'B'),
            array(1000, 1, 'kB'),
            array(1500, 1.5, 'kB'),
            array(2000, 2, 'kB'),
            array(1000 ** 2, 1, 'MB'),
            array(1000 ** 3, 1, 'GB'),
            array(1000 ** 4, 1, 'TB'),
            array(1000 ** 5, 1, 'PB'),
            array(1000 ** 6, 1, 'EB'),
        );
    }

    /**
     * @return array
     */
    public function getBase2()
    {
        return array(
            array(512, 512, 'B'),
            array(1024, 1, 'KiB'),
            array(1536, 1.5, 'KiB'),
            array(2048, 2, 'KiB'),
            array(1024 ** 2, 1, 'MiB'),
            array(1024 ** 3, 1, 'GiB'),
            array(1024 ** 4, 1, 'TiB'),
            array(1024 ** 5, 1, 'PiB'),
            array(1024 ** 6, 1, 'EiB'),
        );
    }

    public function testObfuscate()
    {
        $extension = new StringTwigExtension($this->numberHelper);

        $this->assertSame('T***', $extension->obfuscate(
            'Test',
            array(
                'start'       => 1,
                'end'         => 0,
                'replacement' => '*',
            )
        ));
    }
}
