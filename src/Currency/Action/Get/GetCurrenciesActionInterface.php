<?php

declare(strict_types=1);

namespace App\Currency\Action\Get;

interface GetCurrenciesActionInterface
{
    public function run(GetCurrenciesActionRequest $request): GetCurrenciesActionResponse;
}
