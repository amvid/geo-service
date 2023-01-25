<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency;

use App\Currency\Entity\Currency;
use Ramsey\Uuid\Uuid;

class CurrencyDummy
{
    public const ID = '06147e1c-b11a-445c-a9ca-3b7e26ca0b38';
    public const NAME = 'American Dollar';
    public const CODE = 'USD';
    public const SYMBOL = '$';

    public static function get(): Currency
    {
        $currencyId = Uuid::fromString(self::ID);
        $currency = new Currency($currencyId);
        $currency->setName(self::NAME)->setCode(self::CODE)->setSymbol(self::SYMBOL)->setCreatedAt();
        return $currency;
    }
}
