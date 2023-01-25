<?php

declare(strict_types=1);

namespace App\State\Action\Delete;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DeleteStateActionRequest
{
    public UuidInterface $id;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
    }
}
