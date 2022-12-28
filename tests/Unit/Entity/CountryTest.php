<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Currency\Entity\Currency;
use App\Entity\Country;
use App\SubRegion\Entity\SubRegion;
use App\Timezone\Entity\Timezone;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CountryTest extends TestCase
{
    public function testValidInstantiation(): void
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

        $actual = (new Country())
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
            ->addTimezone($timezone)
            ->setSubRegion($subRegion);

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
        $this->assertEquals($timezone, $actual->getTimezones()->first());
        $this->assertEquals($subRegion, $actual->getSubRegion());
    }
}