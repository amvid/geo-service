<?php

declare(strict_types=1);

namespace App\Airport\Fixtures;

use App\City\Entity\City;
use App\City\Fixtures\CityFixture;
use App\Tests\Unit\Airport\AirportDummy;
use App\Timezone\Entity\Timezone;
use App\Timezone\Fixtures\TimezoneFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AirportFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Timezone $tz */
        $tz = $this->getReference(TimezoneFixture::TIMEZONE_REFERENCE);

        /** @var City $city */
        $city = $this->getReference(CityFixture::CITY_REFERENCE);

        $manager->persist(AirportDummy::get($tz, $city));
        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            TimezoneFixture::class,
            CityFixture::class,
        ];
    }
}
