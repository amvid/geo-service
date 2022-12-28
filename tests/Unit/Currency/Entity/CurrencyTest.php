<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Entity;

use App\Currency\Entity\Currency;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CurrencyTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $name = 'Euro';
        $code = 'EUR';
        $symbol = '€';

        $currency = (new Currency($id))
            ->setName($name)
            ->setCode($code)
            ->setSymbol($symbol);
        $currency->setCreatedAt();

        $this->assertEquals($id, $currency->getId());
        $this->assertEquals($name, $currency->getName());
        $this->assertEquals($code, $currency->getCode());
        $this->assertEquals($symbol, $currency->getSymbol());
        $this->assertNotNull($currency->getCreatedAt());
        $this->assertNotNull($currency->getUpdatedAt());
    }
}