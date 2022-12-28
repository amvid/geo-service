<?php

declare(strict_types=1);

namespace App\Currency\Action\Create;

interface CreateCurrencyActionInterface
{
    public function run(CreateCurrencyActionRequest $request): CreateCurrencyActionResponse;
}
