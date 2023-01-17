<?php

declare(strict_types=1);

namespace App\Currency\Fixtures;

use App\Tests\Unit\Currency\CurrencyDummy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixture extends Fixture
{
    public const CURRENCY_REFERENCE = 'currency';

    public function load(ObjectManager $manager): void
    {
        $currency = CurrencyDummy::get();
        $manager->persist($currency);
        $manager->flush();

        $this->addReference(self::CURRENCY_REFERENCE, $currency);
    }
}
