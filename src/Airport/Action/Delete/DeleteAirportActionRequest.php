<?php

declare(strict_types=1);

namespace App\Airport\Action\Delete;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeleteAirportActionRequest
{
    #[NotBlank]
    public UuidInterface $id;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
    }
}