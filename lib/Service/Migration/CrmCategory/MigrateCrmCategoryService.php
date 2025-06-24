<?php

namespace Base\Module\Service\Migration\CrmCategory;

interface MigrateCrmCategoryService
{
    public const SERVICE_CODE = 'base.module.migration.crm.category.service';

    public function setCategoriesList(array $categories): self;
    public function install(): void;
    public function reInstall(): void;
}