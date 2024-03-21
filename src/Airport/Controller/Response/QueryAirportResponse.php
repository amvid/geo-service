<?php

declare(strict_types=1);

namespace App\Airport\Controller\Response;

class QueryAirportResponse
{
    public string $title;
    public string $iata;
    public string $country;

    public function __construct(string $title, string $iata, string $country)
    {
        $this->title = $title;
        $this->iata = $iata;
        $this->country = $country;
    }
}
