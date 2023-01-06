<?php

declare(strict_types=1);

namespace App\City\Controller\Response;

use App\City\Entity\City;
use App\Country\Controller\Response\CountryResponse;
use App\State\Controller\Response\StateResponse;
use Ramsey\Uuid\UuidInterface;

class CityResponse
{
    public UuidInterface $id;
    public string $title;
    public float $longitude;
    public float $latitude;
    public ?int $altitude = null;
    public CountryResponse $country;
    public StateResponse $state;

    public function __construct(City $city)
    {
        $this->id = $city->getId();
        $this->longitude = $city->getLongitude();
        $this->latitude = $city->getLatitude();
        $this->altitude = $city->getAltitude();
        $this->country = new CountryResponse($city->getCountry());
        $this->state = new StateResponse($city->getState());
    }
}