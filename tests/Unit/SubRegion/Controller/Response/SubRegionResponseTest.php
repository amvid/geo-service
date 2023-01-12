<?php

declare(strict_types=1);

namespace App\Tests\Unit\SubRegion\Controller\Response;

use App\SubRegion\Controller\Response\SubRegionResponse;
use App\Tests\Unit\SubRegion\SubRegionDummy;
use PHPUnit\Framework\TestCase;

class SubRegionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $subRegion = SubRegionDummy::get();
        $actual = new SubRegionResponse($subRegion);

        $this->assertEquals($subRegion->getId(), $actual->id);
        $this->assertEquals($subRegion->getTitle(), $actual->title);
        $this->assertEquals($subRegion->getRegion()->getId(), $actual->region->id);
    }
}