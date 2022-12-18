<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Region\Update;

use App\Action\Region\Update\UpdateRegionActionResponse;
use App\Entity\Region;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UpdateRegionActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::v1();
        $title = 'Europe';
        $region = new Region($id);
        $region->setTitle($title)->setCreatedAt();

        $actual = new UpdateRegionActionResponse($region);

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($title, $actual->title);
        $this->assertEquals($region->getUpdatedAt(), $actual->updatedAt);
        $this->assertEquals($region->getCreatedAt(), $actual->createdAt);
    }
}