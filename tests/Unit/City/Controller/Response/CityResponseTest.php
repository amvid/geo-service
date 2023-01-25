<?php

declare(strict_types=1);

namespace App\Tests\Unit\City\Controller\Response;

use App\City\Controller\Response\CityResponse;
use App\Tests\Unit\City\CityDummy;
use PHPUnit\Framework\TestCase;

class CityResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $city = CityDummy::get();
        $actual = new CityResponse($city);

        $this->assertEquals($city->getId(), $actual->id);
        $this->assertEquals($city->getTitle(), $actual->title);
        $this->assertEquals($city->getLongitude(), $actual->longitude);
        $this->assertEquals($city->getLatitude(), $actual->latitude);
        $this->assertEquals($city->getAltitude(), $actual->altitude);
        $this->assertEquals($city->getState()->getId(), $actual->state->id);
        $this->assertEquals($city->getCountry()->getId(), $actual->country->id);
    }
}
