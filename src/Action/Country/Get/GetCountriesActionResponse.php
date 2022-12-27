<?php

declare(strict_types=1);

namespace App\Action\Country\Get;

use App\Controller\Response\CountryResponse;
use App\Entity\Country;

class GetCountriesActionResponse
{
    public array $response;

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