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
use Nucleos\Twig\Extension\RouterTwigExtension;
use Nucleos\Twig\Extension\StringTwigExtension;
use Nucleos\Twig\Extension\UrlAutoConverterTwigExtension;

final class NucleosTwigExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadDefault(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService(UrlAutoConverterTwigExtension::class);
        $this->assertContainerBuilderHasService(StringTwigExtension::class);
        $this->assertContainerBuilderHasService(RouterTwigExtension::class);
    }

    protected function getContainerExtensions(): array
    {
        return [
            new NucleosTwigExtension(),
        ];
    }
}
