<?php

declare(strict_types=1);

namespace App\Action\Country\Create;

interface CreateCountryActionInterface
{
    public function run(CreateCountryActionRequest $request): CreateCountryActionResponse;
}