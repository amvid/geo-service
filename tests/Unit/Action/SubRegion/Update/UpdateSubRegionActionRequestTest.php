<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\SubRegion\Update;

use App\Action\SubRegion\Update\UpdateSubRegionActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateSubRegionActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $regionId = Uuid::uuid4();
        $title = 'Eastern Europe';

        $actual = new UpdateSubRegionActionRequest($title, $regionId->toString());
        $actual->setId($id->toString());
        $actual->setTitle($title);

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($title, $actual->title);
        $this->assertEquals($regionId, $actual->regionId);
    }
}