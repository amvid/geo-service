<?php

declare(strict_types=1);

namespace App\Currency\Action\Update;

use Ramsey\Uuid\UuidInterface;

interface UpdateCurrencyActionInterface
{
    public function run(UpdateCurrencyActionRequest $request, UuidInterface $id): UpdateCurrencyActionResponse;
}
