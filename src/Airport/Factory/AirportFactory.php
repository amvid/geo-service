<?php

declare(strict_types=1);

namespace App\Airport\Factory;

use App\Airport\Entity\Airport;
use App\City\Entity\City;
use App\Timezone\Entity\Timezone;

class AirportFactory implements AirportFactoryInterface
{
    private Airport $airport;

    public function __construct()
    {
        $this->airport = new Airport();
    }

    public function create(): Airport
    {
        return $this->airport;
    }

    public function setAirport(Airport $airport): AirportFactoryInterface
    {
        $this->airport = $airport;
        return $this;
    }

    public function setTitle(string $title): AirportFactoryInterface
    {
        $this->airport->setTitle($title);
        return $this;
    }

    public function setIcao(string $icao): AirportFactoryInterface
    {
        $this->airport->setIcao($icao);
        return $this;
    }

    public function setIata(string $iata): AirportFactoryInterface
    {
        $this->airport->setIata($iata);
        return $this;
    }

    public function setTimezone(Timezone $timezone): AirportFactoryInterface
    {
        $this->airport->setTimezone($timezone);
        return $this;
    }

    public function setCity(City $city): AirportFactoryInterface
    {
        $this->airport->setCity($city);
        return $this;
    }

    public function setLongitude(float $longitude): AirportFactoryInterface
    {
        $this->airport->setLongitude($longitude);
        return $this;
    }

    public function setLatitude(float $latitude): AirportFactoryInterface
    {
        $this->airport->setLatitude($latitude);
        return $this;
    }

    public function setAltitude(?int $altitude = null): AirportFactoryInterface
    {
        $this->airport->setAltitude($altitude);
        return $this;
    }

    public function setIsActive(?bool $isActive = null): AirportFactoryInterface
    {
        $this->airport->setIsActive($isActive);

        return $this;
    }
}
