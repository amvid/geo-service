<?php

declare(strict_types=1);

namespace App\Airport\Controller\Response;

class QueryChildrenAirportResponse
{
    public string $title;
    public string $iata;
    public string $country;
    public ?string $subregion = null;
    public ?string $region = null;

    /** @var array<QueryAirportResponse> */
    public array $children = [];

    public function __construct(string $title, string $iata, string $country, ?string $region = null, ?string $subregion = null, array $children = [])
    {
        $this->title = $title;
        $this->iata = $iata;
        $this->country = $country;
        $this->subregion = $subregion;
        $this->region = $region;
        $this->children = $children;
    }
}
