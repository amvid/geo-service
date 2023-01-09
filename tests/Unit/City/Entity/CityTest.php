<?php

declare(strict_types=1);

namespace App\Tests\Unit\City\Entity;

use App\City\Entity\City;
use App\Country\Entity\Country;
use App\State\Entity\State;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CityTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $stateId = Uuid::uuid4();
        $state = new State($stateId);

        $countryId = Uuid::uuid4();
        $country = new Country($countryId);

        $cityId = Uuid::uuid4();
        $title = 'Trondheim';
        $actual = new City($cityId);
        $actual->setTitle($title)->setState($state)->setCountry($country);

        $this->assertEquals($title, $actual->getTitle());
        $this->assertEquals($countryId, $actual->getCountry()->getId());
        $this->assertEquals($stateId, $actual->getState()->getId());
    }
}