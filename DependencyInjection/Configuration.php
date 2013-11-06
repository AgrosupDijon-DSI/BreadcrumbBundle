<?php

namespace Cnerta\BreadcrumbBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('cnerta_breadcrumb')
                ->children()
                    ->arrayNode('twig')
                        ->addDefaultsIfNotSet()
                        ->canBeUnset()
                        ->children()
                            ->scalarNode('template')->defaultValue('CnertaBreadcrumbBundle::cnerta_breadcrumb.html.twig')->end()
                        ->end()
                    ->end()
                ->booleanNode('templating')->defaultFalse()->end()
                ->scalarNode('default_renderer')->cannotBeEmpty()->defaultValue('twig')->end()
                ;
        
        return $treeBuilder;
    }
}
