<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Update;

use Ramsey\Uuid\UuidInterface;

interface UpdateSubRegionActionInterface
{
    public function run(UpdateSubRegionActionRequest $request, UuidInterface $id): UpdateSubRegionActionResponse;
}
