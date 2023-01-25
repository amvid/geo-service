<?php

declare(strict_types=1);

namespace App\City\Action\Delete;

interface DeleteCityActionInterface
{
    public function run(DeleteCityActionRequest $request): DeleteCityActionResponse;
}
