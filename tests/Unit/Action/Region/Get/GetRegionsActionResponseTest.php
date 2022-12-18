<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Region\Get;

use App\Action\Region\Get\GetRegionsActionResponse;
use App\Entity\Region;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetRegionsActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id1 = Uuid::uuid7();
        $id2 = Uuid::uuid7();

        $asia = new Region($id1);
        $europe = new Region($id2);

        $actual = new GetRegionsActionResponse([$asia, $europe]);

        $this->assertCount(2, $actual->regions);
        $this->assertEquals($asia, $actual->regions[0]);
        $this->assertEquals($europe, $actual->regions[1]);
    }
}