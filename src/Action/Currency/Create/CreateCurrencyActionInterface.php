<?php

declare(strict_types=1);

namespace App\Action\Currency\Create;

interface CreateCurrencyActionInterface
{
    public function run(CreateCurrencyActionRequest $request): CreateCurrencyActionResponse;
}
