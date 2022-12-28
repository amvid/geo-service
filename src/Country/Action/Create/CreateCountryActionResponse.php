<?php

declare(strict_types=1);

namespace App\Country\Action\Create;

use App\Country\Controller\Response\CountryResponse;
use App\Country\Entity\Country;

class CreateCountryActionResponse
{
    public CountryResponse $countryResponse;

    public function __construct(Country $country)
    {
        $this->countryResponse = new CountryResponse($country);
    }
}