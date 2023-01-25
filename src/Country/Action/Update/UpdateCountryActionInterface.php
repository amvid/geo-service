<?php

declare(strict_types=1);

namespace App\Country\Action\Update;

interface UpdateCountryActionInterface
{
    public function run(UpdateCountryActionRequest $request): UpdateCountryActionResponse;
}
