<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Nucleos\Twig\Extension\RouterExtension;
use Nucleos\Twig\Extension\StringExtension;
use Nucleos\Twig\Extension\UrlAutoConverterExtension;
use Nucleos\Twig\Runtime\RouterRuntime;
use Nucleos\Twig\Runtime\StringRuntime;
use Nucleos\Twig\Runtime\UrlAutoConverterRuntime;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set(UrlAutoConverterExtension::class)
            ->tag('twig.extension')

        ->set(StringExtension::class)
            ->tag('twig.extension')

        ->set(RouterExtension::class)
            ->tag('twig.extension')

        ->set(UrlAutoConverterRuntime::class)
            ->tag('twig.runtime')

        ->set(StringRuntime::class)
            ->tag('twig.runtime')

        ->set(RouterRuntime::class)
            ->tag('twig.runtime')
            ->args([
                new Reference('router'),
            ])
    ;
};
