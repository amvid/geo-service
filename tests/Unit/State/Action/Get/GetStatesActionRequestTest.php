<?php

declare(strict_types=1);

namespace App\Tests\Unit\State\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\State\Action\Get\GetStatesActionRequest;
use PHPUnit\Framework\TestCase;

class GetStatesActionRequestTest extends TestCase
{
    public function testFromArrayShouldReturnNewInstanceOfRequest(): void
    {
        $limit = 10;
        $offset = 0;

        $title = 'New Jersey';
        $countryIso2 = 'US';
        $code = 'NJ';
        $type = 'state';

        $request = [
            'limit' => $limit,
            'offset' => $offset,
            'title' => $title,
            'countryIso2' => $countryIso2,
            'code' => $code,
            'type' => $type,
        ];

        $actual = GetStatesActionRequest::fromArray($request);

        $this->assertEquals($limit, $actual->limit);
        $this->assertEquals($offset, $actual->offset);
        $this->assertEquals($title, $actual->title);
        $this->assertEquals($code, $actual->code);
        $this->assertEquals($countryIso2, $actual->countryIso2);
        $this->assertEquals($type, $actual->type);
    }

    public function testShouldSetDefaultValuesOnNonNumericRequest(): void
    {
        $request = [
            'offset' => 'o',
            'limit' => '1o'
        ];

        $actual = GetStatesActionRequest::fromArray($request);

        $this->assertEquals(LimitOffsetInterface::DEFAULT_LIMIT, $actual->limit);
        $this->assertEquals(LimitOffsetInterface::DEFAULT_OFFSET, $actual->offset);
    }
}
