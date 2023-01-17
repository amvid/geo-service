<?php

declare(strict_types=1);

namespace App\State\Fixtures;

use App\Country\Entity\Country;
use App\Country\Fixtures\CountryFixture;
use App\Tests\Unit\State\StateDummy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StateFixture extends Fixture implements DependentFixtureInterface
{
    public const STATE_REFERENCE = 'state';

    public function load(ObjectManager $manager): void
    {
        /** @var Country $country */
        $country = $this->getReference(CountryFixture::COUNTRY_REFERENCE);
        $state = StateDummy::get($country);

        $manager->persist($state);
        $manager->flush();

        $this->addReference(self::STATE_REFERENCE, $state);
    }

    public function getDependencies(): array
    {
        return [
            CountryFixture::class,
        ];
    }
}
