<?php

declare(strict_types=1);

namespace App\City\Action\Create;

interface CreateCityActionInterface
{
    public function run(CreateCityActionRequest $request): CreateCityActionResponse;
}
