<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Get;

interface GetSubRegionsActionInterface
{
    public function run(GetSubRegionsActionRequest $request): GetSubRegionsActionResponse;
}
