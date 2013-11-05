<?php
namespace Cnerta\BreadcrumbBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * This compiler pass registers the renderers in the RendererProvider.
 */
class AddRenderersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('cnerta_breadcrumb.renderer_provider')) {
            return;
        }
        $definition = $container->getDefinition('cnerta_breadcrumb.renderer_provider');

        $renderers = array();
        
        foreach ($container->findTaggedServiceIds('cnerta_breadcrumb.renderer') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (empty($attributes['alias'])) {
                    throw new \InvalidArgumentException(sprintf('The alias is not defined in the "cnerta_breadcrumb.renderer" tag for the service "%s"', $id));
                }
                $renderers[$attributes['alias']] = $id;
            }
        }
        $definition->replaceArgument(2, $renderers);
    }
}
