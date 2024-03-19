<?php

declare(strict_types=1);

namespace App\Airport\Action\Query;

interface QueryAirportsActionInterface
{
    public function run(QueryAirportsActionRequest $request): QueryAirportsActionResponse;
}
