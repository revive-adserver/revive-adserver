<?php

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
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

    $containerConfigurator->import(SetList::PSR_12);

    $services = $containerConfigurator->services();
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);
};
