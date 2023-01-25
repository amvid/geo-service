<?php

declare(strict_types=1);

namespace App\Airport\Action\Update;

interface UpdateAirportActionInterface
{
    public function run(UpdateAirportActionRequest $request): UpdateAirportActionResponse;
}
