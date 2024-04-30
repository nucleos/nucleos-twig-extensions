<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('nucleos_twig');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode->append($this->getSecureNode());

        return $treeBuilder;
    }

    private function getSecureNode(): NodeDefinition
    {
        $node = (new TreeBuilder('secure'))->getRootNode();

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('mail')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('dot_text')
                             ->useAttributeAsKey('id')
                             ->requiresAtLeastOneElement()
                             ->defaultValue([' [DOT] ', ' (DOT) ', ' [.] '])
                             ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('at_text')
                             ->useAttributeAsKey('id')
                             ->requiresAtLeastOneElement()
                             ->defaultValue([' [AT] ', ' (AT) ', ' [ÄT] '])
                             ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
