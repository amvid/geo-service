<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Action\Create;

use App\Currency\Action\Create\CreateCurrencyActionResponse;
use App\Currency\Entity\Currency;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateCurrencyActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $name = 'Euro';
        $code = 'EUR';
        $symbol = '€';

        $currency = new Currency($id);
        $currency->setName($name);
        $currency->setCode($code);
        $currency->setSymbol($symbol);
        $currency->setCreatedAt();

        $actual = new CreateCurrencyActionResponse($currency);

        $this->assertEquals($id, $actual->currencyResponse->id);
        $this->assertEquals($name, $actual->currencyResponse->name);
        $this->assertEquals($code, $actual->currencyResponse->code);
        $this->assertEquals($symbol, $actual->currencyResponse->symbol);
    }
}
