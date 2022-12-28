<?php

declare(strict_types=1);

namespace App\Action\Country\Delete;

interface DeleteCountryActionInterface
{
    public function run(DeleteCountryActionRequest $request): DeleteCountryActionResponse;
}