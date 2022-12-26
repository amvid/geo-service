<?php

declare(strict_types=1);

namespace App\Action\Country\Update;

interface UpdateCountryActionInterface
{
    public function run(UpdateCountryActionRequest $request): UpdateCountryActionResponse;
}