<?php

declare(strict_types=1);

namespace App\Region\Action\Create;

interface CreateRegionActionInterface
{
    public function run(CreateRegionActionRequest $request): CreateRegionActionResponse;
}
