<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Controller\Response;

use App\Currency\Controller\Response\CurrencyResponse;
use App\Tests\Unit\Currency\CurrencyDummy;
use PHPUnit\Framework\TestCase;

class CurrencyResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $currency = CurrencyDummy::get();
        $actual = new CurrencyResponse($currency);

        $this->assertEquals($currency->getId(), $actual->id);
        $this->assertEquals($currency->getName(), $actual->name);
        $this->assertEquals($currency->getCode(), $actual->code);
        $this->assertEquals($currency->getSymbol(), $actual->symbol);
    }
}
