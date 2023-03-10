<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Update;

interface UpdateSubRegionActionInterface
{
    public function run(UpdateSubRegionActionRequest $request): UpdateSubRegionActionResponse;
}
