<?php

declare(strict_types=1);

namespace App\Airport\Controller\Response;

class QueryAirportResponse
{
    public string $title;
    public string $iata;
    public string $city;
    public string $country;
    public ?string $region = null;
    public ?string $subregion = null;

    public function __construct(string $title, string $iata, string $city, string $country, ?string $region = null, ?string $subregion = null)
    {

        $this->title = $title;
        $this->iata = $iata;
        $this->city = $city;
        $this->country = $country;
        $this->region = $region;
        $this->subregion = $subregion;
    }
}
