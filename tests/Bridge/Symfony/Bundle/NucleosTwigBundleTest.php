<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Tests\Bridge\Symfony\Bundle;

use Nucleos\Twig\Bridge\Symfony\Bundle\NucleosTwigBundle;
use Nucleos\Twig\Bridge\Symfony\DependencyInjection\NucleosTwigExtension;
use PHPUnit\Framework\TestCase;

final class NucleosTwigBundleTest extends TestCase
{
    public function testGetPath(): void
    {
        $bundle = new NucleosTwigBundle();

        static::assertStringEndsWith('Bridge/Symfony/Bundle', \dirname($bundle->getPath()));
    }

    public function testGetContainerExtension(): void
    {
        $bundle = new NucleosTwigBundle();

        static::assertInstanceOf(NucleosTwigExtension::class, $bundle->getContainerExtension());
    }
}
