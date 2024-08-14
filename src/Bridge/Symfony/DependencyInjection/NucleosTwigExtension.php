<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Bridge\Symfony\DependencyInjection;

use Nucleos\Twig\Runtime\StringRuntime;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

final class NucleosTwigExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        $this->configureSecure($config['secure'], $container);
    }

    /**
     * @param array<string, array<string, mixed>> $config
     */
    private function configureSecure(array $config, ContainerBuilder $container): void
    {
        $container->getDefinition(StringRuntime::class)
            ->replaceArgument(0, $config['mail']['at_text'])
            ->replaceArgument(1, $config['mail']['dot_text'])
        ;
    }
}
