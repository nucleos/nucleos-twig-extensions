<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('nucleos_twig');

        $rootNode = $treeBuilder->getRootNode();

        $this->addPaginationSection($rootNode);

        return $treeBuilder;
    }

    private function addPaginationSection(ArrayNodeDefinition $node): void
    {
        $node->children()->arrayNode('pagination')->addDefaultsIfNotSet()->children()->scalarNode(
            'template'
        )->defaultValue('@NucleosTwig/Pager/pagination.html.twig')->end()->scalarNode('extremeLimit')->defaultValue(
            3
        )->end()->scalarNode('nearbyLimit')->defaultValue(2)->end()->end()->end()->end();
    }
}
