<?php

/**
 * Revive Adserver
 * http://www.revive-adserver.com
 *
 * @copyright See the COPYRIGHT.txt file.
 * @license GPLv2 or later, see the LICENSE.txt file.
 */

namespace RV;

use League\Flysystem\Adapter;
use League\Flysystem\Filesystem;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Reference;

class Container implements PsrContainerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Container constructor.
     *
     * @param array  $aConf
     * @param string $hostname If empty
     * @param bool   $isDebug
     */
    public function __construct(array $aConf, $hostname = null, $isDebug = false)
    {
        $containerConfigCache = $this->getConfigCache($hostname, $isDebug);

        if ('test' === $hostname || !$containerConfigCache->isFresh()) {
            $this->rebuildCachedContainer($containerConfigCache, $aConf);
        }

        require_once $containerConfigCache->getPath();
        $this->container = new \ReviveAdserverCachedContainer();
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * Get the ConfigCache for the specified hostname.
     *
     * @param string $hostname
     * @param bool   $isDebug
     *
     * @return ConfigCache
     */
    public function getConfigCache($hostname = "", $isDebug = false)
    {
        if (empty($hostname)) {
            $hostname = OX_getHostName();
        }

        return new ConfigCache(MAX_PATH.'/var/cache/'.$hostname.'_container.php', $isDebug);
    }

    /**
     * Rebuilds the container cache file.
     *
     * @param ConfigCache $containerConfigCache
     * @param array       $aConf
     */
    public function rebuildCachedContainer(ConfigCache $containerConfigCache, array $aConf)
    {
        $containerBuilder = $this->buildContainer($aConf);
        $containerBuilder->compile();

        $dumper = new PhpDumper($containerBuilder);
        $containerConfigCache->write(
            $dumper->dump(array('class' => 'ReviveAdserverCachedContainer')),
            $containerBuilder->getResources()
        );
    }

    /**
     * Guess what, this builds the container.
     *
     * @param array $aConf
     *
     * @return ContainerBuilder
     */
    private function buildContainer(array $aConf)
    {
        $container = new ContainerBuilder();

        self::setParametersFromConfArray($container, $GLOBALS['_MAX']['CONF']);

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
            ->addArgument(new Reference($container->getParameter('store.mode') ?
                'filesystem.adapter.ftp' : // store.mode 1: FTP
                'filesystem.adapter.local' // store.mode 0: Local
            ));

        return $container;
    }

    /**
     * Copies the configuration array into DI parameters as "section.key".
     *
     * @param ContainerInterface $container
     * @param array $aConf
     */
    private static function setParametersFromConfArray(ContainerInterface $container, array $aConf)
    {
        foreach ($aConf as $section => $array) {
            foreach ($array as $key => $value) {
                $container->setParameter("{$section}.{$key}", $value);
            }
        }
    }
}