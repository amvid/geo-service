<?php

declare(strict_types=1);

namespace App\Region\Action\Update;

interface UpdateRegionActionInterface
{
    public function run(UpdateRegionActionRequest $request): UpdateRegionActionResponse;
}
