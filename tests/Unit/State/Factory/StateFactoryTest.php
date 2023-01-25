<?php

declare(strict_types=1);

namespace App\Tests\Unit\State\Factory;

use App\Country\Entity\Country;
use App\State\Factory\StateFactory;
use App\State\Factory\StateFactoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class StateFactoryTest extends TestCase
{
    private StateFactoryInterface $stateFactory;

    protected function setUp(): void
    {
        $this->stateFactory = new StateFactory();
    }

    public function testShouldReturnANewState(): void
    {
        $countryId = Uuid::uuid4();
        $country = new Country($countryId);
        $title = 'New Jersey';
        $code = 'NJ';
        $type = 'state';
        $longitude = 11.12;
        $latitude = 12.11;
        $altitude = 21;

        $actual = $this->stateFactory
            ->setTitle($title)
            ->setCode($code)
            ->setType($type)
            ->setCountry($country)
            ->setLongitude($longitude)
            ->setLatitude($latitude)
            ->setAltitude($altitude)
            ->create();

        $this->assertEquals($title, $actual->getTitle());
        $this->assertEquals($code, $actual->getCode());
        $this->assertEquals($type, $actual->getType());
        $this->assertEquals($longitude, $actual->getLongitude());
        $this->assertEquals($altitude, $actual->getAltitude());
        $this->assertEquals($latitude, $actual->getLatitude());
        $this->assertEquals($countryId, $actual->getCountry()->getId());
    }
}
