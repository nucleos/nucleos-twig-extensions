<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\Twig\Tests\Bridge\Symfony\DependencyInjection;

use Core23\Twig\Bridge\Symfony\DependencyInjection\Core23TwigExtension;
use Core23\Twig\Extension\RouterTwigExtension;
use Core23\Twig\Extension\StringTwigExtension;
use Core23\Twig\Extension\UrlAutoConverterTwigExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

final class Core23TwigExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadDefault(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService('core23_twig.urlautoconverter.extension', UrlAutoConverterTwigExtension::class);
        $this->assertContainerBuilderHasService('core23_twig.string.extension', StringTwigExtension::class);
        $this->assertContainerBuilderHasService('core23_twig.router.extension', RouterTwigExtension::class);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument('core23_twig.router.extension', 1, [
            'template'     => '@Core23Twig/Pager/pagination.html.twig',
            'extremeLimit' => 3,
            'nearbyLimit'  => 2,
        ]);
    }

    public function testLoadCustom(): void
    {
        $this->load([
            'pagination' => [
                'template'     => '@Acme/Pager/pagination.html.twig',
                'extremeLimit' => 10,
                'nearbyLimit'  => 5,
            ],
        ]);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument('core23_twig.router.extension', 1, [
            'template'     => '@Acme/Pager/pagination.html.twig',
            'extremeLimit' => 10,
            'nearbyLimit'  => 5,
        ]);
    }

    protected function getContainerExtensions(): array
    {
        return [
            new Core23TwigExtension(),
        ];
    }
}
