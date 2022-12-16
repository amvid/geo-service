<?php

declare(strict_types=1);

namespace App\Action\Region\Create;

interface CreateRegionActionInterface
{
    public function run(CreateRegionActionRequest $request): CreateRegionActionResponse;
}
