<?php

/** @noinspection PhpUnused */

namespace Base\Module\Install;

use Base\Module\Install\Interface\Install;
use Base\Module\Install\Interface\ReInstall;
use Base\Module\Service\Container;
use Base\Module\Service\Migration\CrmCategory\MigrateCrmCategory;
use Base\Module\Service\Migration\CrmCategory\MigrateCrmCategoryService;
use Base\Module\Service\Tool\ClassList;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class CrmCategoryInstaller implements Install, ReInstall
{
    /**
     * @return array
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     * @throws ReflectionException
     * @throws SystemException
     */
    private function getCrmCategoryList(): array
    {
        /** @var ClassList $classList */
        $classList = Container::get(ClassList::SERVICE_CODE);
        return $classList->setSubClassesFilter([MigrateCrmCategory::class])->getFromLib('Migration');
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     * @throws ReflectionException
     * @throws SystemException
     */
    public function install(): void
    {
        /** @var MigrateCrmCategoryService $userFieldService */
        $userFieldService = Container::get(MigrateCrmCategoryService::SERVICE_CODE);
        $userFieldService->setCategoriesList($this->getCrmCategoryList())->install();
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     * @throws ReflectionException
     * @throws SystemException
     */
    public function reInstall(): void
    {
        /** @var MigrateCrmCategoryService $userFieldService */
        $userFieldService = Container::get(MigrateCrmCategoryService::SERVICE_CODE);
        $userFieldService->setCategoriesList($this->getCrmCategoryList())->reInstall();
    }

    public function getInstallSort(): int
    {
        return 435;
    }

    public function getReInstallSort(): int
    {
        return 435;
    }
}
