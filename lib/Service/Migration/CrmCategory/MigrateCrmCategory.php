<?php

namespace Base\Module\Service\Migration\CrmCategory;

interface MigrateCrmCategory
{
    public static function getEntityTypeId(): int;
    public static function getName(): string;
    public static function getSort(): string;
    public static function getCode(): string;
    public static function isDefault(): bool;
}