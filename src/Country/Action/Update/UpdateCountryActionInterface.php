<?php

declare(strict_types=1);

namespace App\Country\Action\Update;

use Ramsey\Uuid\UuidInterface;

interface UpdateCountryActionInterface
{
    public function run(UpdateCountryActionRequest $request, UuidInterface $id): UpdateCountryActionResponse;
}
