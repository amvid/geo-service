<?php

declare(strict_types=1);

namespace App\Tests\Unit\SubRegion\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Region\Action\Get\GetRegionsActionRequest;
use App\SubRegion\Action\Get\GetSubRegionsActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetSubRegionsActionRequestTest extends TestCase
{
    public function testFromArrayShouldReturnNewInstanceOfRequest(): void
    {
        $limit = 10;
        $offset = 0;
        $title = 'Europe';
        $regionId = Uuid::uuid4();

        $request = [
            'limit' => $limit,
            'offset' => $offset,
            'title' => $title,
            'regionId' => $regionId->toString(),
        ];

        $actual = GetSubRegionsActionRequest::fromArray($request);

        $this->assertEquals($limit, $actual->limit);
        $this->assertEquals($offset, $actual->offset);
        $this->assertEquals($title, $actual->title);
        $this->assertEquals($regionId, $actual->regionId);
    }

    public function testShouldSetDefaultValuesOnNonNumericRequest(): void
    {
        $request = [
            'offset' => 'o',
            'limit' => '1o'
        ];

        $actual = GetRegionsActionRequest::fromArray($request);

        $this->assertEquals(LimitOffsetInterface::DEFAULT_LIMIT, $actual->limit);
        $this->assertEquals(LimitOffsetInterface::DEFAULT_OFFSET, $actual->offset);
    }
}