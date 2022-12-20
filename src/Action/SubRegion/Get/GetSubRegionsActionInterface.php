<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Get;

interface GetSubRegionsActionInterface
{
    public function run(GetSubRegionsActionRequest $request): GetSubRegionsActionResponse;
}