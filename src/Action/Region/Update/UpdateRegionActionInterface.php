<?php

declare(strict_types=1);

namespace App\Action\Region\Update;

interface UpdateRegionActionInterface
{
    public function run(UpdateRegionActionRequest $request): UpdateRegionActionResponse;
}