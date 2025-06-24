<?php

namespace Base\Module\Src\Migration\CrmCategory;

use Base\Module\Service\LazyService;
use Base\Module\Service\Migration\CrmCategory\MigrateCrmCategory;
use Base\Module\Service\Migration\CrmCategory\MigrateCrmCategoryService as IMigrateCrmCategoryService;
use Bitrix\Crm\Category\Entity\Category;
use Bitrix\Crm\Service\Container;
use Bitrix\Crm\Service\Factory;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;

#[LazyService(serviceCode: IMigrateCrmCategoryService::SERVICE_CODE, constructorParams: [])]
class MigrateCrmCategoryService implements IMigrateCrmCategoryService
{
    /**
     * @var MigrateCrmCategory[]
     */
    private array $categories;


    /**
     * @throws LoaderException
     */
    public function __construct()
    {
        Loader::requireModule('crm');
    }

    public function setCategoriesList(array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function install(): void
    {
        foreach ($this->prepareMigrateCategoryList() as $entityTypeId => $categories) {
            $entityFactory = Container::getInstance()->getFactory($entityTypeId);

            if($entityFactory === null || !$entityFactory->isCategoriesEnabled()) {
                continue;
            }

            $existsCategories = $entityFactory->getCategories();

            /** @var MigrateCrmCategory $category */
            foreach ($categories as $category) {
                $isCreated = false;
                $defaultCategory = null;

                foreach ($existsCategories as $existsCategory) {
                    if ($category::isDefault()) {
                        if ($existsCategory->getIsDefault()){
                            if ($existsCategory->getCode() === $category::getCode()) {
                                $isCreated = true;
                            } else {
                                $defaultCategory = $existsCategory;
                            }
                            break;
                        }
                    } elseif ($existsCategory->getCode() === $category::getCode()){
                        $isCreated = true;
                        break;
                    }
                }

                if (!$isCreated) {
                    $this->createCategory($entityFactory, $category, $defaultCategory);
                }
            }
        }
    }

    public function reInstall(): void
    {
        $this->install();
    }

    public function prepareMigrateCategoryList(): array
    {
        $list = [];
        foreach ($this->categories as $category) {
            $list[$category::getEntityTypeId()][] = $category;
        }
        return $list;
    }

    /**
     * @param Factory $entityFactory
     * @param MigrateCrmCategory $category
     * @param Category|null $defaultCategory
     * @return void
     * @noinspection PhpDocSignatureInspection
     */
    private function createCategory(Factory $entityFactory, string $category, ?Category $defaultCategory): void
    {
        $entityFactory->createCategory([
            'CODE' => $category::getCode(),
            'NAME' => $category::getName(),
            'SORT' => $category::getSort(),
            'IS_DEFAULT' => $category::isDefault() ? 'Y' : 'N',
        ])
            ->save();

        $defaultCategory?->setIsDefault(false)->save();
    }

}