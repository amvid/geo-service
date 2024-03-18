<?php

declare(strict_types=1);

namespace App\Nationality\Action\Get;

interface GetNationalitiesActionInterface
{
    public function run(GetNationalitiesActionRequest $request): GetNationalitiesActionResponse;
}
