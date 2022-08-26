<?php

declare(strict_types=1);

namespace ShieldWall\SimpleAuthenticator\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('shield_w4ll');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('route')
                    ->children()
                        ->scalarNode('redirect_success')->end()
                        ->scalarNode('redirect_failure')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
