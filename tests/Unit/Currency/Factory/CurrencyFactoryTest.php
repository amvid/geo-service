<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Factory;

use App\Currency\Factory\CurrencyFactory;
use App\Currency\Factory\CurrencyFactoryInterface;
use PHPUnit\Framework\TestCase;

class CurrencyFactoryTest extends TestCase
{
    private CurrencyFactoryInterface $currencyFactory;

    protected function setUp(): void
    {
        $this->currencyFactory = new CurrencyFactory();
    }

    public function testShouldReturnANewCurrency(): void
    {
        $name = 'Euro';
        $code = 'EUR';
        $symbol = '€';

        $actual = $this->currencyFactory
            ->setName($name)
            ->setCode($code)
            ->setSymbol($symbol)
            ->create();

        $this->assertEquals($name, $actual->getName());
        $this->assertEquals($code, $actual->getCode());
        $this->assertEquals($symbol, $actual->getSymbol());
    }
}
