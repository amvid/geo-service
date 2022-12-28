<?php

declare(strict_types=1);

namespace App\Action\Country\Create;

use App\Controller\Response\CountryResponse;
use App\Entity\Country;

class CreateCountryActionResponse
{
    public CountryResponse $countryResponse;

    public function __construct(Country $country)
    {
        $this->countryResponse = new CountryResponse($country);
    }
}