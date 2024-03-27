<?php

declare(strict_types=1);

namespace REVIVE_ROOT;

use Rector\CodeQuality\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector;
use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector;
use Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector;
use Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector;
use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector;
use Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Php72\Rector\Assign\ListEachRector;
use Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector;
use Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\FunctionLike\MixedTypeRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;

return function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths(
        array_merge(
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
                __DIR__ . '/lib/pear',
                __DIR__ . '/lib/smarty',
            ],
            glob(__DIR__ . '/lib/*.php'),
            glob(__DIR__ . '/*.php'),
        )
    );

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_81,
        SetList::CODE_QUALITY,
    ]);

    $rectorConfig->rules([
        RemoveEmptyClassMethodRector::class,
    ]);

    $rectorConfig->skip([
        __DIR__ . '*/tests/*',
        __DIR__ . '/www/api/rest',
        __DIR__ . '/plugins_repo/openXDeveloperToolbox/www/admin/plugins/oxPlugin/etc',
        __DIR__ . '/lib/pear',
        __DIR__ . '/lib/smarty',
        '*/etc/changes/*.php',
        '*xajax*',
        ExplicitBoolCompareRector::class,
        UseIdenticalOverEqualWithSameTypeRector::class,
        AbsolutizeRequireAndIncludePathRector::class,
        IssetOnPropertyObjectToPropertyExistsRector::class,
        NullToStrictStringFuncCallArgRector::class,
        MixedTypeRector::class,
        RemoveExtraParametersRector::class,
        ClassPropertyAssignToConstructorPromotionRector::class,
        DisallowedEmptyRuleFixerRector::class,
        CombineIfRector::class,
        SimplifyIfElseToTernaryRector::class,
        LocallyCalledStaticMethodToNonStaticRector::class,
        ForRepeatedCountToOwnVariableRector::class,
        SimplifyEmptyCheckOnEmptyArrayRector::class,
        SimplifyUselessVariableRector::class,
        JoinStringConcatRector::class,
        SensitiveConstantNameRector::class,
        ListEachRector::class,
        ReplaceEachAssignmentWithKeyCurrentRector::class,
    ]);
};
