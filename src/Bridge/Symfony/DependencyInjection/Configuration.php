<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node        = $treeBuilder->root('core23_twig');

        $this->addMailSection($node);
        $this->addPaginationSection($node);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addMailSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('mail')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('spam')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('protect')->defaultTrue()->end()
                                ->scalarNode('css_class')->defaultValue('spamme')->end()
                                ->scalarNode('dot_text')->defaultValue('[DOT]')->end()
                                ->scalarNode('at_text')->defaultValue('[AT]')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addPaginationSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('pagination')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('template')->defaultValue('Core23TwigExtensionBundle:Pager:pagination.html.twig')->end()
                        ->scalarNode('extremeLimit')->defaultValue(3)->end()
                        ->scalarNode('nearbyLimit')->defaultValue(2)->end()
                    ->end()
                ->end()
            ->end();
    }
}
