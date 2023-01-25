<?php

declare(strict_types=1);

namespace App\Tests\Unit\Region\Action\Get;

use App\Region\Action\Get\GetRegionsActionResponse;
use App\Region\Entity\Region;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetRegionsActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id1 = Uuid::uuid7();
        $id2 = Uuid::uuid7();

        $asia = new Region($id1);
        $asia->setTitle('Asia')->setCreatedAt();
        $europe = new Region($id2);
        $europe->setTitle('Europe')->setCreatedAt();

        $actual = new GetRegionsActionResponse([$asia, $europe]);

        $this->assertCount(2, $actual->response);
        $this->assertEquals($asia->getId(), $actual->response[0]->id);
        $this->assertEquals($europe->getId(), $actual->response[1]->id);
    }
}
