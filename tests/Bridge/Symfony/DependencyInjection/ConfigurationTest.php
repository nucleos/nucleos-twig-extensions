<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\Twig\Tests\Bridge\Symfony\DependencyInjection;

use Core23\Twig\Bridge\Symfony\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
        ]]);

        $expected = [
            'pagination' => [
                'template'     => '@Core23Twig/Pager/pagination.html.twig',
                'extremeLimit' => 3,
                'nearbyLimit'  => 2,
            ],
        ];

        static::assertSame($expected, $config);
    }

    public function testOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
            'pagination' => [
                'template'     => '@Acme/Pager/pagination.html.twig',
                'extremeLimit' => 10,
                'nearbyLimit'  => 5,
            ],
        ]]);

        $expected = [
            'pagination' => [
                'template'     => '@Acme/Pager/pagination.html.twig',
                'extremeLimit' => 10,
                'nearbyLimit'  => 5,
            ],
        ];

        static::assertSame($expected, $config);
    }
}
