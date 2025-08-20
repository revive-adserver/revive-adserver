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

namespace RV\Config;

use League\Flysystem\Adapter;
use League\Flysystem\Filesystem;
use RV\DependencyInjection\Compiler\Html5ZipManagerPass;
use RV\Manager\Html5ZipManager;
use RV\Parser\DomainParser;
use RV\Parser\Html5\AdobeEdgeParser;
use RV\Parser\Html5\MetaParser;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AdminServiceConfigurator
{
    /**
     * Configure services that are not used by the delivery scripts.
     *
     * @param ContainerBuilder $container
     *
     * @return ContainerBuilder
     */
    public static function configure(ContainerBuilder $container)
    {
        $container
            ->register('filesystem.adapter.local', Adapter\Local::class)
            ->addArgument('%store.webDir%')
            ->addArgument(0);

        $container
            ->register('filesystem.adapter.ftp', Adapter\Ftp::class)
            ->addArgument([
                'host' => '%store.ftpHost%',
                'username' => '%store.ftpUsername%',
                'password' => '%store.ftpPassword%',
                'root' => '%store.ftpPath%',
                'passive' => '%store.ftpPassive%',
            ]);

        $container
            ->register('filesystem', Filesystem::class)
            ->setPublic(true)
            ->addArgument(new Reference(
                $container->getParameter('store.mode') ?
                'filesystem.adapter.ftp' : // store.mode 1: FTP
                'filesystem.adapter.local', // store.mode 0: Local
            ));

        $container
            ->addCompilerPass(new Html5ZipManagerPass())
            ->register('html5.zip.manager', Html5ZipManager::class)
            ->setPublic(true)
            ->addArgument(new Reference('filesystem'));

        $container
            ->register('html5.parser.meta', MetaParser::class)
            ->addTag('html5.parser', ['priority' => 0]);

        $container
            ->register('html5.parser.adobe_edge', AdobeEdgeParser::class)
            ->addTag('html5.parser', ['priority' => 5]);

        $container
            ->register('cache.adapter.fs', FilesystemAdapter::class)
            ->addArgument('')
            ->addArgument($container->getParameter('delivery.cacheExpire'))
            ->addArgument(MAX_PATH . '/var/cache')
        ;

        $container
            ->register('cache.psr16', Psr16Cache::class)
            ->setPublic(true)
            ->addArgument(new Reference('cache.adapter.fs'))
        ;

        $container
            ->register('domain.parser', DomainParser::class)
            ->setPublic(true)
            ->addArgument(new Reference('cache.psr16'))
        ;

        return $container;
    }
}
