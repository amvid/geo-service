<?php

declare(strict_types=1);

namespace App\Country\Fixtures;

use App\Currency\Entity\Currency;
use App\Currency\Fixtures\CurrencyFixture;
use App\SubRegion\Entity\SubRegion;
use App\SubRegion\Fixtures\SubRegionFixture;
use App\Tests\Unit\Country\CountryDummy;
use App\Timezone\Entity\Timezone;
use App\Timezone\Fixtures\TimezoneFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CountryFixture extends Fixture implements DependentFixtureInterface
{
    public const COUNTRY_REFERENCE = 'country';

    public function load(ObjectManager $manager): void
    {
        /** @var Timezone $tz */
        $tz = $this->getReference(TimezoneFixture::TIMEZONE_REFERENCE);

        /** @var SubRegion $subRegion */
        $subRegion = $this->getReference(SubRegionFixture::SUBREGION_REFERENCE);

        /** @var Currency $currency */
        $currency = $this->getReference(CurrencyFixture::CURRENCY_REFERENCE);
        $country = CountryDummy::get($tz, $subRegion, $currency);

        $manager->persist($country);
        $manager->flush();

        $this->addReference(self::COUNTRY_REFERENCE, $country);
    }

    public function getDependencies(): array
    {
        return [
            SubRegionFixture::class,
        ];
    }
}
