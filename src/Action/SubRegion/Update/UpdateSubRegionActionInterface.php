<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Update;

interface UpdateSubRegionActionInterface
{
    public function run(UpdateSubRegionActionRequest $request): UpdateSubRegionActionResponse;
}