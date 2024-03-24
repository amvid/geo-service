<?php

declare(strict_types=1);

namespace App\Region\Action\Update;

use Ramsey\Uuid\UuidInterface;

interface UpdateRegionActionInterface
{
    public function run(UpdateRegionActionRequest $request, UuidInterface $id): UpdateRegionActionResponse;
}
