<?php

declare(strict_types=1);

namespace App\City\Action\Get;

use App\City\Controller\Response\CityResponse;

class GetCitiesActionResponse
{
    /**
     * @var array<CityResponse> $cities
     */
    public array $cities = [];

    public function __construct(iterable $cities)
    {
        foreach ($cities as $city) {
            $this->cities[] = new CityResponse($city);
        }
    }
}
