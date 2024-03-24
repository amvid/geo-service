<?php

declare(strict_types=1);

namespace App\State\Action\Update;

use Ramsey\Uuid\UuidInterface;

interface UpdateStateActionInterface
{
    public function run(UpdateStateActionRequest $request, UuidInterface $id): UpdateStateActionResponse;
}
