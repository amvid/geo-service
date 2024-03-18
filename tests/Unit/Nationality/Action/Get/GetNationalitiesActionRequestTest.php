<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Nationality\Action\Get\GetNationalitiesActionRequest;
use PHPUnit\Framework\TestCase;

class GetNationalitiesActionRequestTest extends TestCase
{
    public function testFromArrayShouldReturnNewInstanceOfRequest(): void
    {
        $limit = 10;
        $offset = 0;
        $title = 'American';

        $request = [
            'limit' => $limit,
            'offset' => $offset,
            'title' => $title,
        ];

        $actual = GetNationalitiesActionRequest::fromArray($request);

        $this->assertEquals($limit, $actual->limit);
        $this->assertEquals($offset, $actual->offset);
        $this->assertEquals($title, $actual->title);
    }

    public function testShouldSetDefaultValuesOnNonNumericRequest(): void
    {
        $request = [
            'offset' => 'o',
            'limit' => '1o'
        ];

        $actual = GetNationalitiesActionRequest::fromArray($request);

        $this->assertEquals(LimitOffsetInterface::DEFAULT_LIMIT, $actual->limit);
        $this->assertEquals(LimitOffsetInterface::DEFAULT_OFFSET, $actual->offset);
    }
}
