<?php

declare(strict_types=1);

namespace App\Action\Currency\Delete;

interface DeleteCurrencyActionInterface
{
    public function run(DeleteCurrencyActionRequest $request): DeleteCurrencyActionResponse;

}
