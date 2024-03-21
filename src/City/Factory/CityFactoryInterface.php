<?php

declare(strict_types=1);

namespace App\City\Factory;

use App\City\Entity\City;
use App\Country\Entity\Country;
use App\State\Entity\State;

interface CityFactoryInterface
{
    public function setCity(City $city): self;

    public function setCountry(Country $country): self;

    public function setState(?State $state = null): self;

    public function setTitle(string $title): self;

    public function setLongitude(float $longitude): self;

    public function setLatitude(float $latitude): self;

    public function setAltitude(?int $altitude = null): self;

    public function setIata(?string $iata): self;

    public function create(): City;
}
