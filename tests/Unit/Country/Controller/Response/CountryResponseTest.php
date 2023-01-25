<?php

declare(strict_types=1);

namespace App\Tests\Unit\Country\Controller\Response;

use App\Country\Controller\Response\CountryResponse;
use App\Tests\Unit\Country\CountryDummy;
use PHPUnit\Framework\TestCase;

class CountryResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $country = CountryDummy::get();
        $actual = new CountryResponse($country);

        $this->assertCount(count($country->getTimezones()), $actual->timezones);
        $this->assertEquals($country->getTimezones()[0]->getId(), $actual->timezones[0]->id);
        $this->assertEquals($country->getId(), $actual->id);
        $this->assertEquals($country->getTitle(), $actual->title);
        $this->assertEquals($country->getIso2(), $actual->iso2);
        $this->assertEquals($country->getIso3(), $actual->iso3);
        $this->assertEquals($country->getPhoneCode(), $actual->phoneCode);
        $this->assertEquals($country->getNumericCode(), $actual->numericCode);
        $this->assertEquals($country->getFlag(), $actual->flag);
        $this->assertEquals($country->getTld(), $actual->tld);
        $this->assertEquals($country->getNativeTitle(), $actual->nativeTitle);
        ;
        $this->assertEquals($country->getCurrency()->getId(), $actual->currency->id);
        $this->assertEquals($country->getSubRegion()->getId(), $actual->subRegion->id);
        $this->assertEquals($country->getLongitude(), $actual->longitude);
        $this->assertEquals($country->getLatitude(), $actual->latitude);
        $this->assertEquals($country->getAltitude(), $actual->altitude);
    }
}
