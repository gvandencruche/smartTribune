<?php
namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class AnswersChannelFAQType extends AbstractEnumType
{
    public const FAQ = 'faq';
    public const BOT = 'bot';
  
    protected static $choices = [
        self::FAQ => 'faq',
        self::BOT => 'bot',
    ];
}
