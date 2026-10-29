<?php

declare(strict_types=1);

namespace REVIVE_ROOT;

use Rector\CodeQuality\Rector\ClassMethod\ExplicitReturnNullRector;
use Rector\CodeQuality\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector;
use Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector;
use Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Php72\Rector\Assign\ListEachRector;
use Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector;
use Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\SafeDeclareStrictTypesRector;

return RectorConfig::configure()
    ->withCache(__DIR__ . '/var/cache/tools/rector')
    ->withPaths(array_merge(
        [
            __DIR__ . '/etc',
            __DIR__ . '/lib/max',
            __DIR__ . '/lib/OA',
            __DIR__ . '/lib/OX',
            __DIR__ . '/lib/RV',
            __DIR__ . '/lib/simpletest',
            __DIR__ . '/maintenance',
            __DIR__ . '/plugins_repo',
            __DIR__ . '/scripts',
            __DIR__ . '/www/admin',
            __DIR__ . '/www/api',
            __DIR__ . '/www/delivery_dev',
            __DIR__ . '/www/devel',
            __DIR__ . '/lib/pear',
            __DIR__ . '/lib/smarty',
        ],
        glob(__DIR__ . '/lib/*.php'),
        glob(__DIR__ . '/*.php'),
    ))
    ->withSets([
        LevelSetList::UP_TO_PHP_82,
        SetList::CODE_QUALITY,
    ])
    ->withRules([
        RemoveEmptyClassMethodRector::class,
    ])
    ->withSkip([
        __DIR__ . '*/tests/*',
        __DIR__ . '/www/api/rest',
        __DIR__ . '/plugins_repo/openXDeveloperToolbox/www/admin/plugins/oxPlugin/etc',
        __DIR__ . '/lib/pear',
        __DIR__ . '/lib/smarty',
        __DIR__ . '/lib/max/language',
        '*/etc/changes/*.php',
        '*xajax*',
        UseIdenticalOverEqualWithSameTypeRector::class,
        AbsolutizeRequireAndIncludePathRector::class,
        IssetOnPropertyObjectToPropertyExistsRector::class,
        RemoveExtraParametersRector::class,
        ClassPropertyAssignToConstructorPromotionRector::class,
        LocallyCalledStaticMethodToNonStaticRector::class,
        SimplifyEmptyCheckOnEmptyArrayRector::class,
        SensitiveConstantNameRector::class,
        ListEachRector::class,
        ReplaceEachAssignmentWithKeyCurrentRector::class,
        ExplicitReturnNullRector::class,
        SafeDeclareStrictTypesRector::class,
    ])
;
