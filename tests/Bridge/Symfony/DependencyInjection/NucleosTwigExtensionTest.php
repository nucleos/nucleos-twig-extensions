<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Tests\Bridge\Symfony\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Nucleos\Twig\Bridge\Symfony\DependencyInjection\NucleosTwigExtension;
use Nucleos\Twig\Extension\RouterExtension;
use Nucleos\Twig\Extension\StringExtension;
use Nucleos\Twig\Extension\UrlAutoConverterExtension;

final class NucleosTwigExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadDefault(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService(UrlAutoConverterExtension::class);
        $this->assertContainerBuilderHasService(StringExtension::class);
        $this->assertContainerBuilderHasService(RouterExtension::class);
    }

    protected function getContainerExtensions(): array
    {
        return [
            new NucleosTwigExtension(),
        ];
    }
}
