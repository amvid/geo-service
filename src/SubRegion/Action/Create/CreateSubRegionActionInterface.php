<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Create;

interface CreateSubRegionActionInterface
{
    public function run(CreateSubRegionActionRequest $request): CreateSubRegionActionResponse;
}
