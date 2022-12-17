<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Region\Create;

use App\Action\Region\Create\CreateRegionActionResponse;
use App\Entity\Region;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CreateRegionActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::v1();
        $title = 'Europe';

        $region = new Region($id);
        $region->setTitle($title);
        $region->setCreatedAt();

        $actual = new CreateRegionActionResponse($region);

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($title, $actual->title);
        $this->assertEquals($region->getCreatedAt(), $actual->createdAt);
        $this->assertEquals($region->getUpdatedAt(), $actual->updatedAt);
    }
}