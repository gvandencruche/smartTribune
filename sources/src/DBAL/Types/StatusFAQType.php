<?php
namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class StatusFAQType extends AbstractEnumType
{
    public const DRAFT = 'draft';
    public const PUBLISHED = 'published';
  
    protected static $choices = [
        self::DRAFT => 'draft',
        self::PUBLISHED => 'published',
    ];
}
