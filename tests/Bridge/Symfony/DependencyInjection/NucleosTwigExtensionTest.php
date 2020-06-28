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

        $this->assertContainerBuilderHasService(
            'nucleos_twig.urlautoconverter.extension',
            UrlAutoConverterTwigExtension::class
        );
        $this->assertContainerBuilderHasService('nucleos_twig.string.extension', StringTwigExtension::class);
        $this->assertContainerBuilderHasService('nucleos_twig.router.extension', RouterTwigExtension::class);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'nucleos_twig.router.extension',
            2,
            [
                'template'     => '@NucleosTwig/Pager/pagination.html.twig',
                'extremeLimit' => 3,
                'nearbyLimit'  => 2,
            ]
        );
    }

    public function testLoadCustom(): void
    {
        $this->load(
            [
                'pagination' => [
                    'template'     => '@Acme/Pager/pagination.html.twig',
                    'extremeLimit' => 10,
                    'nearbyLimit'  => 5,
                ],
            ]
        );

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'nucleos_twig.router.extension',
            2,
            [
                'template'     => '@Acme/Pager/pagination.html.twig',
                'extremeLimit' => 10,
                'nearbyLimit'  => 5,
            ]
        );
    }

    protected function getContainerExtensions(): array
    {
        return [
            new NucleosTwigExtension(),
        ];
    }
}
