<?php

declare(strict_types=1);

namespace App\Tests\Unit\Region\Action\Get;

use App\Application\Controller\Request\LimitOffsetParser;
use App\Region\Action\Get\GetRegionsActionRequest;
use PHPUnit\Framework\TestCase;

class GetRegionsActionRequestTest extends TestCase
{
    public function testFromArrayShouldReturnNewInstanceOfRequest(): void
    {
        $limit = 10;
        $offset = 0;
        $title = 'Europe';

        $request = [
            'limit' => $limit,
            'offset' => $offset,
            'title' => $title,
        ];

        $actual = GetRegionsActionRequest::fromArray($request);

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

        $actual = GetRegionsActionRequest::fromArray($request);

        $this->assertEquals(LimitOffsetParser::DEFAULT_LIMIT, $actual->limit);
        $this->assertEquals(LimitOffsetParser::DEFAULT_OFFSET, $actual->offset);
    }
}