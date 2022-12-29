<?php

declare(strict_types=1);

namespace App\State\Action\Update;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateStateActionRequest
{
    #[NotBlank]
    public UuidInterface $id;

    #[Length(min: 1, max: 150)]
    public ?string $title;

    public ?float $longitude;

    public ?float $latitude;

    public ?int $altitude;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
    }
}