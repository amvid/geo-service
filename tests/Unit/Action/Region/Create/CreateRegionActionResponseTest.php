<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Region\Create;

use App\Action\Region\Create\CreateRegionActionResponse;
use App\Entity\Region;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateRegionActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();
        $title = 'Europe';

        $region = new Region($id);
        $region->setTitle($title);
        $region->setCreatedAt();

        $actual = new CreateRegionActionResponse($region);

        $this->assertEquals($id, $actual->regionResponse->id);
        $this->assertEquals($title, $actual->regionResponse->title);
        $this->assertEquals($region->getCreatedAt(), $actual->regionResponse->createdAt);
        $this->assertEquals($region->getUpdatedAt(), $actual->regionResponse->updatedAt);
    }
}