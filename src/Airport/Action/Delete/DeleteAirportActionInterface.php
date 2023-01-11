<?php

declare(strict_types=1);

namespace App\Airport\Action\Delete;

interface DeleteAirportActionInterface
{
    public function run(DeleteAirportActionRequest $request): DeleteAirportActionResponse;
}