<?php

declare(strict_types=1);

namespace App\Action\Currency\Update;

interface UpdateCurrencyActionInterface
{
    public function run(UpdateCurrencyActionRequest $request): UpdateCurrencyActionResponse;
}