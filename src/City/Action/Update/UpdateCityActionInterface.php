<?php

declare(strict_types=1);

namespace App\City\Action\Update;

interface UpdateCityActionInterface
{
    public function run(UpdateCityActionRequest $request): UpdateCityActionResponse;
}
