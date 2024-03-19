<?php

declare(strict_types=1);

namespace App\Airport\Action\Query;

use App\Airport\Controller\Response\QueryAirportResponse;

class QueryAirportsActionResponse
{
    /**
     * @var iterable<QueryAirportResponse>
     */
    public iterable $airports = [];

    /** @param iterable<QueryAirportResponse> $airports */
    public function __construct(iterable $airports)
    {
        $this->airports = $airports;
    }
}
