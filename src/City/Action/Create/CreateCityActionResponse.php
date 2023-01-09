<?php

declare(strict_types=1);

namespace App\City\Action\Create;

use App\City\Controller\Response\CityResponse;
use App\City\Entity\City;

class CreateCityActionResponse
{
    public CityResponse $city;

    public function __construct(City $city)
    {
        $this->city = new CityResponse($city);
    }
}