<?php

declare(strict_types=1);

namespace App\Action\Currency\Get;

interface GetCurrenciesActionInterface
{
    public function run(GetCurrenciesActionRequest $request): GetCurrenciesActionResponse;
}