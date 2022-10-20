<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $parameters = $ecsConfig->parameters();
    $parameters->set(Option::PARALLEL, true);

    $parameters->set(Option::CACHE_DIRECTORY, '.ecs_cache');

    // A. full sets
    $ecsConfig->import(SetList::PSR_12);
    $ecsConfig->import(SetList::CLEAN_CODE);
    $ecsConfig->import(SetList::DOCTRINE_ANNOTATIONS);

    // B. standalone rule
    $services = $ecsConfig->services();
    $services->set(ConcatSpaceFixer::class)
        ->call('configure', [[
            'spacing' => 'one'
        ]])
    ;
};
