<?php

declare(strict_types=1);

namespace App\City\Action\Get;

interface GetCitiesActionInterface
{
    public function run(GetCitiesActionRequest $request): GetCitiesActionResponse;
}