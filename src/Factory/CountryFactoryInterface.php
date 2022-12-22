<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Country;
use App\Entity\Currency;
use App\Entity\SubRegion;
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

    public function setAltitude(int $altitude): self;

    public function create(): Country;
}