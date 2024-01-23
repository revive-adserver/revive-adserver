<?php

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;

return ECSConfig::configure()
    ->withPaths(array_merge([
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
            __DIR__ . '/tests/testClasses',
        ],
        glob(__DIR__ . '/lib/*.php'),
        glob(__DIR__ . '/*.php'),
        glob(__DIR__ . '/tests/.php'),
    ))
    ->withSkip([
        __DIR__ . '/lib/max/language',
        __DIR__ . '/plugins_repo/openXDeveloperToolbox',
        __DIR__ . '/www/devel/lib/xajax/examples',
    ])
    ->withRules([
        ArraySyntaxFixer::class,
        NullableTypeDeclarationForDefaultNullValueFixer::class
    ])
    ->withPhpCsFixerSets(perCS20: true)
    ->withPreparedSets(psr12: true);
