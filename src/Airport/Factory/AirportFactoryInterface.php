<?php

declare(strict_types=1);

namespace App\Airport\Factory;

use App\Airport\Entity\Airport;
use App\City\Entity\City;
use App\Timezone\Entity\Timezone;

interface AirportFactoryInterface
{
    public function create(): Airport;

    public function setAirport(Airport $airport): self;

    public function setTitle(string $title): self;

    public function setIcao(string $icao): self;

    public function setIata(string $iata): self;

    public function setTimezone(Timezone $timezone): self;

    public function setCity(City $city): self;

    public function setLongitude(float $longitude): self;

    public function setLatitude(float $latitude): self;

    public function setAltitude(?int $altitude = null): self;

    public function setIsActive(?bool $isActive = null): self;
}
