<?php

declare(strict_types=1);

namespace App\Tests\Unit\Country\Controller\Response;

use App\Country\Controller\Response\PhoneCodeResponse;
use App\Tests\Unit\Country\CountryDummy;
use PHPUnit\Framework\TestCase;

class PhoneCodeResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $country = CountryDummy::get();
        $actual = new PhoneCodeResponse($country);

        $this->assertEquals($country->getPhoneCode(), $actual->phoneCode);
        $this->assertEquals($country->getTitle(), $actual->title);
        $this->assertEquals($country->getIso2(), $actual->iso2);
        $this->assertEquals($country->getIso3(), $actual->iso3);;
        $this->assertEquals($country->getFlag(), $actual->flag);
    }
}
