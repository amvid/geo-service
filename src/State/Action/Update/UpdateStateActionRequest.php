<?php

declare(strict_types=1);

namespace App\State\Action\Update;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Length;

class UpdateStateActionRequest
{
    public UuidInterface $id;

    #[Length(min: 1, max: 150)]
    public ?string $title = null;

    #[Length(min: 1, max: 50)]
    public ?string $type = null;

    public ?float $longitude = null;

    public ?float $latitude = null;

    public ?int $altitude = null;

    public ?string $countryIso2 = null;

    public function setId(string $id): self
    {
        $this->id = Uuid::fromString($id);
        return $this;
    }
}