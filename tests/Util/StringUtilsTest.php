<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Tests\Util;

use Core23\TwigExtensions\Util\StringUtils;
use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase
{
    /**
     * @dataProvider getObfuscatedStrings
     *
     * @param string $input
     * @param int    $start
     * @param int    $end
     * @param string $replacement
     * @param string $output
     */
    public function testObfuscate($input, $start, $end, $replacement, $output)
    {
        $this->assertSame($output, StringUtils::obfuscate($input, $start, $end, $replacement));
    }

    /**
     * @return array
     */
    public function getObfuscatedStrings()
    {
        return array(
            array('Foo Bar Baz', 'start' => 1, 'end' => 1, 'replacement' => ' ', 'F         z'),
            array('Foo Bar Baz', 'start' => 1, 'end' => 1, 'replacement' => '#', 'F#########z'),
            array('Foo Bar Baz', 'start' => 0, 'end' => 3, 'replacement' => '#', '########Baz'),
            array('Foo Bar Baz', 'start' => 2, 'end' => 0, 'replacement' => '#', 'Fo#########'),
            array('Foobar', 'start' => 5, 'end' => 0, 'replacement' => '#', 'Foobar'),
            array('Foobar', 'start' => 6, 'end' => 0, 'replacement' => '#', 'Foobar'),
            array('Foobar', 'start' => 4, 'end' => 2, 'replacement' => '#', 'Foobar'),
            array('Foobar', 'start' => 4, 'end' => 3, 'replacement' => '#', 'Foobar'),
            array('Foobar', 'start' => 0, 'end' => 5, 'replacement' => '#', 'Foobar'),
            array('Foobar', 'start' => 0, 'end' => 6, 'replacement' => '#', 'Foobar'),
        );
    }
}
