<?php

declare(strict_types=1);

require_once __DIR__ . '/phpstan-bootstrap.php';

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, array_merge(
        [
            __DIR__ . '/etc',
            __DIR__ . '/lib/max',
            __DIR__ . '/lib/OA',
            __DIR__ . '/lib/OX',
            __DIR__ . '/lib/RV',
            __DIR__ . '/maintenance',
            __DIR__ . '/plugins_repo',
            __DIR__ . '/scripts',
            __DIR__ . '/www/admin',
            __DIR__ . '/www/api',
            __DIR__ . '/www/delivery_dev',
            __DIR__ . '/www/devel',
        ],
        glob(__DIR__ . '/lib/*.php'),
        glob(__DIR__ . '/*.php'),
    ));

    $parameters->set(Option::AUTOLOAD_PATHS, [
        __DIR__ . '/lib/pear',
        __DIR__ . '/lib/smarty',
    ]);

    $parameters->set(Option::SKIP, [
        __DIR__ . '*/tests/*',
        '*xajax*',
        \Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector::class,
        \Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector::class,
        \Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector::class,
        \Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector::class,
        \Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector::class,
    ]);

    // Define what rule sets will be applied
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::PHP_72);
    //    $containerConfigurator->import(SetList::PHP_73);
    //    $containerConfigurator->import(SetList::PHP_74);
    //    $containerConfigurator->import(SetList::PHP_80);
    //    $containerConfigurator->import(SetList::PHP_81);

    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();

    // register a single rule
    //$services->set(\Rector\Php72\Rector\While_\WhileEachToForeachRector::class);
};
