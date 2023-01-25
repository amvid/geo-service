<?php

declare(strict_types=1);

namespace App\Tests\Unit\Region\Action\Update;

use App\Region\Action\Update\UpdateRegionActionResponse;
use App\Region\Entity\Region;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateRegionActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();
        $title = 'Europe';
        $region = new Region($id);
        $region->setTitle($title)->setCreatedAt();

        $actual = new UpdateRegionActionResponse($region);

        $this->assertEquals($id, $actual->regionResponse->id);
        $this->assertEquals($title, $actual->regionResponse->title);
    }
}
