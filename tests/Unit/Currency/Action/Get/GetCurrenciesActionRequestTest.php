<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Currency\Action\Get\GetCurrenciesActionRequest;
use PHPUnit\Framework\TestCase;

class GetCurrenciesActionRequestTest extends TestCase
{
    public function testFromArrayShouldReturnNewInstanceOfRequest(): void
    {
        $limit = 10;
        $offset = 0;
        $name = 'Euro';
        $code = 'EUR';
        $symbol = '€';

        $request = [
            'limit' => $limit,
            'offset' => $offset,
            'name' => $name,
            'code' => $code,
            'symbol' => $symbol,
        ];

        $actual = GetCurrenciesActionRequest::fromArray($request);

        $this->assertEquals($limit, $actual->limit);
        $this->assertEquals($offset, $actual->offset);
        $this->assertEquals($name, $actual->name);
        $this->assertEquals($code, $actual->code);
        $this->assertEquals($symbol, $actual->symbol);
    }

    public function testShouldSetDefaultValuesOnNonNumericRequest(): void
    {
        $request = [
            'offset' => 'o',
            'limit' => '1o'
        ];

        $actual = GetCurrenciesActionRequest::fromArray($request);

        $this->assertEquals(LimitOffsetInterface::DEFAULT_LIMIT, $actual->limit);
        $this->assertEquals(LimitOffsetInterface::DEFAULT_OFFSET, $actual->offset);
    }
}
