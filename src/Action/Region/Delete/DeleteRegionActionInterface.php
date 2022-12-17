<?php

declare(strict_types=1);

namespace App\Action\Region\Delete;

interface DeleteRegionActionInterface
{
    public function run(DeleteRegionActionRequest $request): DeleteRegionActionResponse;

}
