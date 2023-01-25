<?php

declare(strict_types=1);

namespace App\Currency\Action\Delete;

interface DeleteCurrencyActionInterface
{
    public function run(DeleteCurrencyActionRequest $request): DeleteCurrencyActionResponse;
}
