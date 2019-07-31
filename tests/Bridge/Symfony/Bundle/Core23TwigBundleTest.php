<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\Twig\Tests\Bridge\Symfony\Bundle;

use Core23\Twig\Bridge\Symfony\Bundle\Core23TwigBundle;
use Core23\Twig\Bridge\Symfony\DependencyInjection\Core23TwigExtension;
use PHPUnit\Framework\TestCase;

final class Core23TwigBundleTest extends TestCase
{
    public function testGetPath(): void
    {
        $bundle = new Core23TwigBundle();

        static::assertStringEndsWith('Bridge/Symfony/Bundle', \dirname($bundle->getPath()));
    }

    public function testGetContainerExtension(): void
    {
        $bundle = new Core23TwigBundle();

        static::assertInstanceOf(Core23TwigExtension::class, $bundle->getContainerExtension());
    }
}
