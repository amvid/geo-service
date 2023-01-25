<?php

declare(strict_types=1);

namespace App\Country\Action\Delete;

interface DeleteCountryActionInterface
{
    public function run(DeleteCountryActionRequest $request): DeleteCountryActionResponse;
}
