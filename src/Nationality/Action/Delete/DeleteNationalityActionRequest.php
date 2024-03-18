<?php

declare(strict_types=1);

namespace App\Nationality\Action\Delete;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeleteNationalityActionRequest
{
    #[NotBlank]
    public UuidInterface $id;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
    }
}
