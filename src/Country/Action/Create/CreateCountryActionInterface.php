<?php

declare(strict_types=1);

namespace App\Country\Action\Create;

interface CreateCountryActionInterface
{
    public function run(CreateCountryActionRequest $request): CreateCountryActionResponse;
}