<?php

declare(strict_types=1);

namespace App\Airport\Controller\Response;

class QueryAirportResponse
{
    public string $title;
    public string $iata;
    public string $country;
    public string $region;
    public string $subregion;

    public function __construct(string $title, string $iata, string $country, string $region, string $subregion)
    {

        $this->title = $title;
        $this->iata = $iata;
        $this->country = $country;
        $this->region = $region;
        $this->subregion = $subregion;
    }
}
