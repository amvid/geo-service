<?php

declare(strict_types=1);

namespace App\Airport\Action\Update;

use Ramsey\Uuid\UuidInterface;

interface UpdateAirportActionInterface
{
    public function run(UpdateAirportActionRequest $request, UuidInterface $id): UpdateAirportActionResponse;
}
