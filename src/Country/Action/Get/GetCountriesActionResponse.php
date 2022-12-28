<?php

declare(strict_types=1);

namespace App\Country\Action\Get;

use App\Country\Controller\Response\CountryResponse;
use App\Country\Entity\Country;

class GetCountriesActionResponse
{
    /** @var array<CountryResponse> $response */
    public array $response = [];

    /**
     * @param array<Country> $countries
     */
    public function __construct(array $countries)
    {
        foreach ($countries as $country) {
            $this->response[] = new CountryResponse($country);
        }
    }
}