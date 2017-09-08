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

namespace RV;

use League\Flysystem\Adapter;
use League\Flysystem\Filesystem;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use RV\DependencyInjection\Compiler\Html5ZipManagerPass;
use RV\Manager\Html5ZipManager;
use RV\Parser\Html5\AdobeEdgeParser;
use RV\Parser\Html5\MetaParser;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
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
     * @param bool   $isDelivery
     * @param string $hostname
     * @param bool   $isDebug
     */
    public function __construct(array $aConf, $isDelivery = false, $hostname = null, $isDebug = false)
    {
        $containerConfigCache = $this->getConfigCache($hostname, $isDelivery, $isDebug);

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
     * @param bool   $isDelivery
     * @param bool   $isDebug
     *
     * @return ConfigCache
     */
    public function getConfigCache($hostname = "", $isDelivery = false, $isDebug = false)
    {
        $filename =
            MAX_PATH.
            '/var/cache/'.
            ($hostname ?: OX_getHostName()).
            ($isDelivery ? '_delivery' : '_admin').
            ($isDebug ? '_debug' : '').
            '_container.php';

        return new ConfigCache($filename, $isDebug);
    }

    /**
     * Rebuilds the container cache file.
     *
     * @param ConfigCache $containerConfigCache
     * @param array       $aConf
     * @param bool        $isDelivery
     */
    public function rebuildCachedContainer(ConfigCache $containerConfigCache, array $aConf, $isDelivery = false)
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
     * @param bool  $isDelivery
     *
     * @return ContainerBuilder
     */
    private function buildContainer(array $aConf, $isDelivery = false)
    {
        $container = new ContainerBuilder();

        self::setParametersFromConfArray($container, $aConf);

        $this->addDeliveryServices($container);

        if (!$isDelivery) {
            $this->addAdminServices($container);
        }

        return $container;
    }

    /**
     * Adds services used both by delivery and admin.
     *
     * @param ContainerBuilder $container
     *
     * @return ContainerBuilder
     */
    private function addDeliveryServices(ContainerBuilder $container)
    {
        // Nothing just yet

        return $container;
    }

    /**
     * Adds services used only by admin that shouldn't be loaded during delivery.
     *
     * @param ContainerBuilder $container
     *
     * @return ContainerBuilder
     */
    private function addAdminServices(ContainerBuilder $container)
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
            ->addArgument(new Reference($container->getParameter('store.mode') ?
                'filesystem.adapter.ftp' : // store.mode 1: FTP
                'filesystem.adapter.local' // store.mode 0: Local
            ));

        $container
            ->addCompilerPass(new Html5ZipManagerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 0)
            ->register('html5.zip.manager', Html5ZipManager::class)
            ->addArgument(new Reference('filesystem'));

        $container
            ->register('html5.parser.meta', MetaParser::class)
            ->addTag('html5.parser', ['priority' => 0]);

        $container
            ->register('html5.parser.adobe_edge', AdobeEdgeParser::class)
            ->addTag('html5.parser', ['priority' => 5]);

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