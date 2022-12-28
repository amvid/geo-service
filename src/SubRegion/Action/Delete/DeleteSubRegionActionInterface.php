<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Delete;

interface DeleteSubRegionActionInterface
{
    public function run(DeleteSubRegionActionRequest $request): DeleteSubRegionActionResponse;

}
