<?php

declare(strict_types=1);

namespace App\Airport\Controller\Response;

class QueryAirportResponse
{
    public string $title;
    public string $iata;
    public string $country;

    /** @var array<QueryAirportResponse> */
    public array $children = [];

    public function __construct(string $title, string $iata, string $country, array $children = [])
    {
        $this->title = $title;
        $this->iata = $iata;
        $this->country = $country;
        $this->children = $children;
    }
}
