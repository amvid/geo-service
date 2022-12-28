<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Action\Update;

use App\Currency\Action\Update\UpdateCurrencyActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateCurrencyActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $name = 'Euro';
        $code = 'EUR';
        $symbol = '€';

        $actual = new UpdateCurrencyActionRequest();
        $actual->setId($id->toString());
        $actual->setName($name);
        $actual->setCode($code);
        $actual->setSymbol($symbol);

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($name, $actual->name);
        $this->assertEquals($code, $actual->code);
        $this->assertEquals($symbol, $actual->symbol);
    }
}