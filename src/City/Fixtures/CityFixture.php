<?php

declare(strict_types=1);

namespace App\City\Fixtures;

use App\Country\Entity\Country;
use App\Country\Fixtures\CountryFixture;
use App\State\Entity\State;
use App\State\Fixtures\StateFixture;
use App\Tests\Unit\City\CityDummy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CityFixture extends Fixture implements DependentFixtureInterface
{
    public const CITY_REFERENCE = 'city';

    public function load(ObjectManager $manager): void
    {
        /** @var Country $country */
        $country = $this->getReference(CountryFixture::COUNTRY_REFERENCE);

        /** @var State $state */
        $state = $this->getReference(StateFixture::STATE_REFERENCE);
        $city = CityDummy::get($country, $state);

        $manager->persist($city);
        $manager->flush();

        $this->addReference(self::CITY_REFERENCE, $city);
    }

    public function getDependencies(): array
    {
        return [
            CountryFixture::class,
            StateFixture::class,
        ];
    }
}
