<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Delete;

interface DeleteSubRegionActionInterface
{
    public function run(DeleteSubRegionActionRequest $request): DeleteSubRegionActionResponse;

}
