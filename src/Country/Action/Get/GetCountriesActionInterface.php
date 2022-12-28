<?php

declare(strict_types=1);

namespace App\Country\Action\Get;

interface GetCountriesActionInterface
{
    public function run(GetCountriesActionRequest $request): GetCountriesActionResponse;
}