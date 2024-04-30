<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Tests\Bridge\Symfony\DependencyInjection;

use Nucleos\Twig\Bridge\Symfony\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

final class ConfigurationTest extends TestCase
{
    public function testDefaultOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
        ]]);

        $expected = [
            'secure' => [
                'mail' => [
                    'dot_text'  => [' [DOT] ', ' (DOT) ', ' [.] '],
                    'at_text'   => [' [AT] ', ' (AT) ', ' [ÄT] '],
                ],
            ],
        ];

        self::assertSame($expected, $config);
    }

    public function testOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
            'secure' => [
                'mail' => [
                    'dot_text'  => ['[DOT]'],
                    'at_text'   => ['[AT'],
                ],
            ],
        ]]);

        $expected = [
            'secure' => [
                'mail' => [
                    'dot_text'  => ['[DOT]'],
                    'at_text'   => ['[AT'],
                ],
            ],
        ];

        self::assertSame($expected, $config);
    }
}
