<?php

declare(strict_types=1);

namespace App\City\Action\Update;

use Ramsey\Uuid\UuidInterface;

interface UpdateCityActionInterface
{
    public function run(UpdateCityActionRequest $request, UuidInterface $id): UpdateCityActionResponse;
}
