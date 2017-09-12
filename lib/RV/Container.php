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

use Psr\Container\ContainerInterface as PsrContainerInterface;
use RV\Config\ConfigCache;
use RV\Config\AdminServiceConfigurator;
use Symfony\Component\DependencyInjection\Config\ContainerParametersResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Filesystem\Exception\IOException;

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
     */
    public function __construct(array $aConf, $isDelivery = false, $hostname = null)
    {
        $container = $this->initContainerWithParameters($aConf);

        $configCache = $this->getConfigCache($container, $hostname, $isDelivery);

        if ('test' === $hostname || !$configCache->isFresh()) {
            try {
                $this->rebuildCachedContainer(
                    self::addServices($container, $isDelivery),
                    $configCache
                );
            } catch (IOException $e) {
                // The cache couldn't be written, use the builder instead
                $this->container = $container;

                return;
            }
        }

        require_once $configCache->getPath();
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
     * @param ContainerBuilder $container
     * @param string           $hostname
     * @param bool             $isDelivery
     *
     * @return ConfigCache
     */
    public function getConfigCache(ContainerBuilder $container, $hostname = "", $isDelivery = false)
    {
        $filename =
            MAX_PATH.
            '/var/cache/'.
            ($hostname ?: OX_getHostName()).
            ($isDelivery ? '_delivery' : '_admin').
            '_container.php';

        return new ConfigCache($filename, $container);
    }

    /**
     * Rebuilds the container cache file.
     *
     * @param ContainerBuilder $container
     * @param ConfigCache      $configCache
     *
     * @throws IOException
     *
     * @return ContainerInterface
     */
    public function rebuildCachedContainer(ContainerBuilder $container, ConfigCache $configCache)
    {
        $container->compile();

        $dumper = new PhpDumper($container);
        $configCache->write(
            $dumper->dump(array('class' => 'ReviveAdserverCachedContainer')),
            $container->getResources()
        );

        return $container;
    }

    /**
     * Build a basinc container, loading parameters form the config file.
     *
     * @param array $aConf
     *
     * @return ContainerBuilder
     */
    private function initContainerWithParameters(array $aConf)
    {
        $container = new ContainerBuilder();

        $paramResource = $this->getParametersResource($aConf);

        foreach ($paramResource->getParameters() as $key => $value) {
            $container->setParameter($key, $value);
        }

        return $container->addResource($paramResource);
    }

    /**
     * @param array $aConf
     *
     * @return ContainerParametersResource
     */
    private function getParametersResource(array $aConf)
    {
        $parameters = [];
        foreach ($aConf as $section => $array) {
            foreach ($array as $key => $value) {
                $parameters["{$section}.{$key}"] = $value;
            }
        }

        return new ContainerParametersResource($parameters);
    }

    /**
     * @param ContainerBuilder $container
     * @param bool             $isDelivery
     *
     * @return ContainerBuilder
     */
    private static function addServices(ContainerBuilder $container, $isDelivery)
    {
        if (!$isDelivery) {
            $container = AdminServiceConfigurator::configure($container);
        }

        return $container;
    }
}