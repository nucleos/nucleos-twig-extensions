<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Nucleos\Twig\Extension\RouterTwigExtension;
use Nucleos\Twig\Extension\StringTwigExtension;
use Nucleos\Twig\Extension\UrlAutoConverterTwigExtension;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set(UrlAutoConverterTwigExtension::class)
            ->tag('twig.extension')

        ->set(StringTwigExtension::class)
            ->tag('twig.extension')

        ->set(RouterTwigExtension::class)
            ->tag('twig.extension')
            ->args([
                new Reference('router'),
            ])
    ;
};
