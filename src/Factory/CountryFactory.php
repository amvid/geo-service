<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Country;
use App\Entity\Currency;
use App\Entity\SubRegion;
use Doctrine\Common\Collections\Collection;

class CountryFactory implements CountryFactoryInterface
{
    private Country $country;

    public function __construct()
    {
        $this->country = new Country();
    }

    public function setCountry(Country $country): CountryFactoryInterface
    {
        $this->country = $country;
        return $this;
    }

    public function setSubRegion(SubRegion $subRegion): CountryFactoryInterface
    {
        $this->country->setSubRegion($subRegion);
        return $this;
    }

    public function setTimezones(Collection $timezones): CountryFactoryInterface
    {
        foreach ($timezones as $timezone) {
            $this->country->addTimezone($timezone);
        }

        return $this;
    }

    public function setCurrency(Currency $currency): CountryFactoryInterface
    {
        $this->country->setCurrency($currency);
        return $this;
    }

    public function setTitle(string $title): CountryFactoryInterface
    {
        $this->country->setTitle($title);
        return $this;
    }

    public function setNativeTitle(?string $nativeTitle = null): CountryFactoryInterface
    {
        $this->country->setNativeTitle($nativeTitle);
        return $this;
    }

    public function setIso2(string $iso2): CountryFactoryInterface
    {
        $this->country->setIso2($iso2);
        return $this;
    }

    public function setIso3(string $iso3): CountryFactoryInterface
    {
        $this->country->setIso3($iso3);
        return $this;
    }

    public function setNumericCode(string $numericCode): CountryFactoryInterface
    {
        $this->country->setNumericCode($numericCode);
        return $this;
    }

    public function setPhoneCode(string $phoneCode): CountryFactoryInterface
    {
        $this->country->setPhoneCode($phoneCode);
        return $this;
    }

    public function setFlag(string $flag): CountryFactoryInterface
    {
        $this->country->setFlag($flag);
        return $this;
    }

    public function setTld(string $tld): CountryFactoryInterface
    {
        $this->country->setTld($tld);
        return $this;
    }

    public function setLongitude(float $longitude): CountryFactoryInterface
    {
        $this->country->setLongitude($longitude);
        return $this;
    }

    public function setLatitude(float $latitude): CountryFactoryInterface
    {
        $this->country->setLatitude($latitude);
        return $this;
    }

    public function setAltitude(int $altitude): CountryFactoryInterface
    {
        $this->country->setAltitude($altitude);
        return $this;
    }

    public function create(): Country
    {
        return $this->country;
    }
}