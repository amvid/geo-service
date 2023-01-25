<?php

declare(strict_types=1);

namespace App\Currency\Action\Update;

interface UpdateCurrencyActionInterface
{
    public function run(UpdateCurrencyActionRequest $request): UpdateCurrencyActionResponse;
}
