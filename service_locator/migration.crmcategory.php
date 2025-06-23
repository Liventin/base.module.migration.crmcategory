<?php
defined('B_PROLOG_INCLUDED') || die;

use Base\Module\Service\Migration\CrmCategory\MigrateCrmCategoryService;

return [
    'base.module.migration.smart.process' => [
        'className' => MigrateCrmCategoryService::class,
        'constructorParams' => [],
    ],
];
