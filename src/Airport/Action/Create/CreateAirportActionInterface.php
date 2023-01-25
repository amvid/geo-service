<?php

declare(strict_types=1);

namespace App\Airport\Action\Create;

interface CreateAirportActionInterface
{
    public function run(CreateAirportActionRequest $request): CreateAirportActionResponse;
}
