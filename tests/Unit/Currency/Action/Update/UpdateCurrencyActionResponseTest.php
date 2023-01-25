<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Action\Update;

use App\Currency\Action\Update\UpdateCurrencyActionResponse;
use App\Currency\Entity\Currency;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateCurrencyActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $name = 'Euro';
        $code = 'EUR';
        $symbol = '€';

        $currency = new Currency($id);
        $currency
            ->setName($name)
            ->setCode($code)
            ->setSymbol($symbol)
            ->setCreatedAt();

        $actual = new UpdateCurrencyActionResponse($currency);

        $this->assertEquals($id, $actual->currencyResponse->id);
        $this->assertEquals($name, $actual->currencyResponse->name);
        $this->assertEquals($code, $actual->currencyResponse->code);
        $this->assertEquals($symbol, $actual->currencyResponse->symbol);
    }
}
