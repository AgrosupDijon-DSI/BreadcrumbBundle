<?php

namespace Cnerta\BreadcrumbBundle\Tests\DependencyInjection;

use Cnerta\BreadcrumbBundle\DependencyInjection\CnertaBreadcrumbExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CnertaBreadcrumbExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $container = new ContainerBuilder();
        $loader = new CnertaBreadcrumbExtension();
        $loader->load(array(array()), $container);

        $this->assertTrue($container->hasDefinition('cnerta_breadcrumb.renderer.twig'), 'The twig renderer is loaded');
        $this->assertEquals('CnertaBreadcrumbBundle::cnerta_breadcrumb.html.twig', $container->getParameter('cnerta_breadcrumb.renderer.twig.template'));
        $this->assertEquals('twig', $container->getParameter('cnerta_breadcrumb.default_renderer'));
    }

    public function testEnableTwig()
    {
        $container = new ContainerBuilder();
        $loader = new CnertaBreadcrumbExtension();
        $loader->load(array(array('twig' => true)), $container);
        $this->assertTrue($container->hasDefinition('cnerta_breadcrumb.renderer.twig'));
        $this->assertEquals('CnertaBreadcrumbBundle::cnerta_breadcrumb.html.twig', $container->getParameter('cnerta_breadcrumb.renderer.twig.template'));
    }

    public function testOverwriteTwigTemplate()
    {
        $container = new ContainerBuilder();
        $loader = new CnertaBreadcrumbExtension();
        $loader->load(array(array('twig' => array('template' => 'foobar'))), $container);
        $this->assertTrue($container->hasDefinition('cnerta_breadcrumb.renderer.twig'));
        $this->assertEquals('foobar', $container->getParameter('cnerta_breadcrumb.renderer.twig.template'));
    }
}
