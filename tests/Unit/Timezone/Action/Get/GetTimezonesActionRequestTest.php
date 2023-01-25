<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Timezone\Action\Get\GetTimezonesActionRequest;
use PHPUnit\Framework\TestCase;

class GetTimezonesActionRequestTest extends TestCase
{
    public function testFromArrayShouldReturnNewInstanceOfRequest(): void
    {
        $limit = 10;
        $offset = 0;
        $title = 'Europe/Oslo (GMT+01:00)';
        $code = 'Europe/Oslo';
        $utc = '+01:00';

        $request = [
            'limit' => $limit,
            'offset' => $offset,
            'title' => $title,
            'code' => $code,
            'utc' => $utc,
        ];

        $actual = GetTimezonesActionRequest::fromArray($request);

        $this->assertEquals($limit, $actual->limit);
        $this->assertEquals($offset, $actual->offset);
        $this->assertEquals($title, $actual->title);
        $this->assertEquals($code, $actual->code);
        $this->assertEquals($utc, $actual->utc);
    }

    public function testShouldSetDefaultValuesOnNonNumericRequest(): void
    {
        $request = [
            'offset' => 'o',
            'limit' => '1o'
        ];

        $actual = GetTimezonesActionRequest::fromArray($request);

        $this->assertEquals(LimitOffsetInterface::DEFAULT_LIMIT, $actual->limit);
        $this->assertEquals(LimitOffsetInterface::DEFAULT_OFFSET, $actual->offset);
    }
}
