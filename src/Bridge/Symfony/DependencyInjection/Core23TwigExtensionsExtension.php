<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class Core23TwigExtensionsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->getDefinition('core23_twig.router.extension')
            ->replaceArgument(1, $config['pagination']);

        $this->configureMail($config, $container);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function configureMail($config, ContainerBuilder $container): void
    {
        $container->setParameter('core23_twig.urlautoconverter.secure_mail', $config['mail']['spam']['protect']);
        $container->setParameter('core23_twig.urlautoconverter.mail_css_class', $config['mail']['spam']['css_class']);
        $container->setParameter('core23_twig.urlautoconverter.mail_at_text', $config['mail']['spam']['at_text']);
        $container->setParameter('core23_twig.urlautoconverter.mail_dot_text', $config['mail']['spam']['dot_text']);
    }
}
