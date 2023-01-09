<?php

declare(strict_types=1);

namespace App\City\Factory;

use App\City\Entity\City;
use App\Country\Entity\Country;
use App\State\Entity\State;

class CityFactory implements CityFactoryInterface
{
    private City $city;

    public function __construct()
    {
        $this->city = new City();
    }

    public function setCity(City $city): CityFactoryInterface
    {
        $this->city = $city;
        return $this;
    }

    public function setCountry(Country $country): CityFactoryInterface
    {
        $this->city->setCountry($country);
        return $this;
    }

    public function setState(?State $state = null): CityFactoryInterface
    {
        $this->city->setState($state);
        return $this;
    }

    public function setTitle(string $title): CityFactoryInterface
    {
        $this->city->setTitle($title);
        return $this;
    }

    public function setLongitude(float $longitude): CityFactoryInterface
    {
        $this->city->setLongitude($longitude);
        return $this;
    }

    public function setLatitude(float $latitude): CityFactoryInterface
    {
        $this->city->setLatitude($latitude);
        return $this;
    }

    public function setAltitude(?int $altitude = null): CityFactoryInterface
    {
        $this->city->setAltitude($altitude);
        return $this;
    }

    public function create(): City
    {
        return $this->city;
    }
}