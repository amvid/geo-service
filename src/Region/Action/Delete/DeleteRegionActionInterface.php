<?php

declare(strict_types=1);

namespace App\Region\Action\Delete;

interface DeleteRegionActionInterface
{
    public function run(DeleteRegionActionRequest $request): DeleteRegionActionResponse;
}
