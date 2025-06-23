# base.module.migration.crmcategory

<table>
<tr>
<td>
<a href="https://github.com/Liventin/base.module">Bitrix Base Module</a>
</td>
</tr>
</table>

install | update

```
"require": {
    "liventin/base.module.migration.crmcategory": "^1.0.0"
}
```
redirect (optional)
```
"extra": {
  "service-redirect": {
    "liventin/base.module.migration.crmcategory": "module.name",
  }
}
```
PhpStorm Live Template
```php
<?php

namespace ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Migration\CrmCategory\ApplicationsEvaluations;


use ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Service\Migration\CrmCategory\MigrateCrmCategory;

class CategoryExample implements MigrateCrmCategory
{
    public static function getEntityTypeId(): int
    {
        return 1;
    }

    public static function getName(): string
    {
        return 'name';
    }

    public static function getSort(): string
    {
        return 500;
    }

    public static function getCode(): string
    {
        return 'CATEGORY_CODE';
    }

    public static function isDefault(): bool
    {
        return true;
    }
}
```