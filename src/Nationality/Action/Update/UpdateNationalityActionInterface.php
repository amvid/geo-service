<?php

declare(strict_types=1);

namespace App\Nationality\Action\Update;

use Ramsey\Uuid\UuidInterface;

interface UpdateNationalityActionInterface
{
    public function run(UpdateNationalityActionRequest $request, UuidInterface $id): UpdateNationalityActionResponse;
}
