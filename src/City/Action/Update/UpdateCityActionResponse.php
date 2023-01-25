<?php

declare(strict_types=1);

namespace App\City\Action\Update;

use App\City\Controller\Response\CityResponse;
use App\City\Entity\City;

class UpdateCityActionResponse
{
    public CityResponse $city;

    public function __construct(City $city)
    {
        $this->city = new CityResponse($city);
    }
}
