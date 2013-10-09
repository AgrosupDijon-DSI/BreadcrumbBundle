<?php

namespace Cnerta\BreadcrumbBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Cnerta\BreadcrumbBundle\DependencyInjection\Compiler\AddRenderersPass;

class CnertaBreadcrumbBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddRenderersPass());

    }

}
