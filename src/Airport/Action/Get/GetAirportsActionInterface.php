<?php

declare(strict_types=1);

namespace App\Airport\Action\Get;

interface GetAirportsActionInterface
{
    public function run(GetAirportsActionRequest $request): GetAirportsActionResponse;
}