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

use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use League\Flysystem\Visibility;
use League\Flysystem\Filesystem;
use RV\DependencyInjection\Compiler\Html5ZipManagerPass;
use RV\Manager\Html5ZipManager;
use RV\Parser\DomainParser;
use RV\Parser\Html5\AdobeEdgeParser;
use RV\Parser\Html5\MetaParser;
use RV\Sync;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

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
        self::configureSerializerServices($container);

        $container
            ->register('filesystem.adapter.local', LocalFilesystemAdapter::class)
            ->addArgument('%store.webDir%')
            ->addArgument(new Reference('filesystem.visibility'))
            ->addArgument(0);

        $container
            ->register('filesystem.visibility', PortableVisibilityConverter::class)
            ->setFactory([PortableVisibilityConverter::class, 'fromArray'])
            ->addArgument([])
            ->addArgument(Visibility::PUBLIC);

        $container
            ->register('filesystem.ftp.options', FtpConnectionOptions::class)
            ->setFactory([FtpConnectionOptions::class, 'fromArray'])
            ->addArgument([
                'host' => '%store.ftpHost%',
                'username' => '%store.ftpUsername%',
                'password' => '%store.ftpPassword%',
                'root' => '%store.ftpPath%',
                'passive' => (bool) $container->getParameter('store.ftpPassive'),
            ]);

        $container
            ->register('filesystem.adapter.ftp', FtpAdapter::class)
            ->addArgument(new Reference('filesystem.ftp.options'))
            ->addArgument(null)
            ->addArgument(null)
            ->addArgument(new Reference('filesystem.visibility'));

        $container
            ->register('filesystem', Filesystem::class)
            ->setPublic(true)
            ->addArgument(new Reference(
                $container->getParameter('store.mode') ?
                'filesystem.adapter.ftp' : // store.mode 1: FTP
                'filesystem.adapter.local', // store.mode 0: Local
            ))
            ->addArgument(['visibility' => Visibility::PUBLIC, 'directory_visibility' => Visibility::PUBLIC]);

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

        $container
            ->register(Sync::class, Sync::class)
            ->setPublic(true)
            ->setArguments([null, null, null, new Reference(SerializerInterface::class)]);

        return $container;
    }

    private static function configureSerializerServices(ContainerBuilder $container): void
    {
        $container
            ->register('serializer.mapping.class_metadata_factory', ClassMetadataFactory::class)
            ->addArgument(new Reference('serializer.mapping.loader.attribute'));

        $container
            ->register('serializer.mapping.loader.attribute', AttributeLoader::class);

        $container
            ->register('serializer.name_converter.camel_case_to_snake_case', CamelCaseToSnakeCaseNameConverter::class);

        $container
            ->register('serializer.name_converter.metadata_aware', MetadataAwareNameConverter::class)
            ->addArgument(new Reference('serializer.mapping.class_metadata_factory'))
            ->addArgument(new Reference('serializer.name_converter.camel_case_to_snake_case'));

        $container
            ->register('property_info.reflection_extractor', ReflectionExtractor::class);

        $container
            ->register('property_info', PropertyInfoExtractor::class)
            ->addArgument([])
            ->addArgument([new Reference('property_info.reflection_extractor')])
            ->addArgument([])
            ->addArgument([new Reference('property_info.reflection_extractor')])
            ->addArgument([new Reference('property_info.reflection_extractor')]);

        $container
            ->register('property_accessor', PropertyAccessor::class)
            ->setPublic(true);

        $container
            ->register('serializer.normalizer.object', ObjectNormalizer::class)
            ->addArgument(new Reference('serializer.mapping.class_metadata_factory'))
            ->addArgument(new Reference('serializer.name_converter.metadata_aware'))
            ->addArgument(new Reference('property_accessor'))
            ->addArgument(new Reference('property_info'));

        $container
            ->register('serializer.encoder.json', JsonEncoder::class);

        $container
            ->register('serializer', Serializer::class)
            ->setPublic(true)
            ->addArgument([new Reference('serializer.normalizer.object')])
            ->addArgument([new Reference('serializer.encoder.json')]);

        $container
            ->setAlias(SerializerInterface::class, 'serializer')
            ->setPublic(true);
    }
}
