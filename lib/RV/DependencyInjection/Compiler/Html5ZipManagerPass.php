<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

namespace RV\DependencyInjection\Compiler;

use RV\Manager\Html5ZipManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class Html5ZipManagerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('html5.zip.manager')) {
            return;
        }

        $definition = $container->findDefinition('html5.zip.manager');

        $taggedServices = $container->findTaggedServiceIds('html5.parser');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addParser', array(
                    new Reference($id),
                    $attributes['priority']
                ));
            }
        }
    }
}