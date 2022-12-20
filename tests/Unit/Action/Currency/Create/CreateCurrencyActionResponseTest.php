<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Currency\Create;

use App\Action\Currency\Create\CreateCurrencyActionResponse;
use App\Entity\Currency;
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
        $this->assertEquals($currency->getCreatedAt(), $actual->currencyResponse->createdAt);
        $this->assertEquals($currency->getUpdatedAt(), $actual->currencyResponse->updatedAt);
    }
}