<?php

declare(strict_types=1);

namespace App\Country\Factory;

use App\Country\Entity\Country;
use App\Currency\Entity\Currency;
use App\SubRegion\Entity\SubRegion;
use Doctrine\Common\Collections\Collection;

interface CountryFactoryInterface
{
    public function setCountry(Country $country): self;

    public function setSubRegion(SubRegion $subRegion): self;

    public function setTimezones(Collection $timezones): self;

    public function setCurrency(Currency $currency): self;

    public function setTitle(string $title): self;

    public function setNativeTitle(?string $nativeTitle = null): self;

    public function setIso2(string $iso2): self;

    public function setIso3(string $iso3): self;

    public function setNumericCode(string $numericCode): self;

    public function setPhoneCode(string $phoneCode): self;

    public function setFlag(string $flag): self;

    public function setTld(string $tld): self;

    public function setLongitude(float $longitude): self;

    public function setLatitude(float $latitude): self;

    public function setAltitude(?int $altitude = null): self;

    public function create(): Country;
}