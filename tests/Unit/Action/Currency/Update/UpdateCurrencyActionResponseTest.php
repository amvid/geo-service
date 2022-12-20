<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Currency\Update;

use App\Action\Currency\Update\UpdateCurrencyActionResponse;
use App\Entity\Currency;
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

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($name, $actual->name);
        $this->assertEquals($code, $actual->code);
        $this->assertEquals($symbol, $actual->symbol);
        $this->assertEquals($currency->getUpdatedAt(), $actual->updatedAt);
        $this->assertEquals($currency->getCreatedAt(), $actual->createdAt);
    }
}