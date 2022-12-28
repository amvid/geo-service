<?php

declare(strict_types=1);

namespace App\Tests\Unit\Country\Factory;

use App\Country\Factory\CountryFactory;
use App\Country\Factory\CountryFactoryInterface;
use App\Currency\Entity\Currency;
use App\SubRegion\Entity\SubRegion;
use App\Timezone\Entity\Timezone;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CountryFactoryTest extends TestCase
{
    private CountryFactoryInterface $factory;

    protected function setUp(): void
    {
        $this->factory = new CountryFactory();
    }

    public function testShouldReturnANewCountry(): void
    {
        $title = 'Norway';
        $nativeTitle = 'Norge';
        $iso2 = 'NO';
        $iso3 = 'NOR';
        $numericCode = '578';
        $phoneCode = '47';
        $flag = '🇳🇴';
        $tld = '.no';
        $longitude = 10.0;
        $latitude = 62.0;

        $currencyId = Uuid::uuid4();
        $currency = new Currency($currencyId);
        $currency->setCode('NOK')->setName('Norwegian Krone')->setSymbol('kr')->setCreatedAt();

        $subRegionId = Uuid::uuid4();
        $subRegion = new SubRegion($subRegionId);
        $subRegion->setTitle('Northern Europe')->setCreatedAt();

        $timezoneId = Uuid::uuid4();
        $timezone = new Timezone($timezoneId);
        $timezone->setCode('Europe/Oslo')->setTitle('Europe/Oslo (GMT+02:00')->setUtc('+02:00')->setCreatedAt();
        $timezones = new ArrayCollection();
        $timezones->add($timezone);

        $actual = $this->factory
            ->setTitle($title)
            ->setNativeTitle($nativeTitle)
            ->setTld($tld)
            ->setIso2($iso2)
            ->setIso3($iso3)
            ->setPhoneCode($phoneCode)
            ->setNumericCode($numericCode)
            ->setLongitude($longitude)
            ->setLatitude($latitude)
            ->setFlag($flag)
            ->setCurrency($currency)
            ->setTimezones($timezones)
            ->setSubRegion($subRegion)
            ->create();

        $this->assertEquals($title, $actual->getTitle());
        $this->assertEquals($nativeTitle, $actual->getNativeTitle());
        $this->assertEquals($iso2, $actual->getIso2());
        $this->assertEquals($iso3, $actual->getIso3());
        $this->assertEquals($numericCode, $actual->getNumericCode());
        $this->assertEquals($phoneCode, $actual->getPhoneCode());
        $this->assertEquals($tld, $actual->getTld());
        $this->assertEquals($flag, $actual->getFlag());
        $this->assertEquals($longitude, $actual->getLongitude());
        $this->assertEquals($latitude, $actual->getLatitude());
        $this->assertEquals($currency, $actual->getCurrency());
        $this->assertEquals($timezones, $actual->getTimezones());
        $this->assertEquals($subRegion, $actual->getSubRegion());
    }

}