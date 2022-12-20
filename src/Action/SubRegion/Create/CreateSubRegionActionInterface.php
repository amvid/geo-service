<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Create;

interface CreateSubRegionActionInterface
{
    public function run(CreateSubRegionActionRequest $request): CreateSubRegionActionResponse;
}
