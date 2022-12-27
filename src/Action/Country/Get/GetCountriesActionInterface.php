<?php

declare(strict_types=1);

namespace App\Action\Country\Get;

interface GetCountriesActionInterface
{
    public function run(GetCountriesActionRequest $request): GetCountriesActionResponse;
}