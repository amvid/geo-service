<?php

declare(strict_types=1);

namespace App\Airport\Action\Update;

use App\Application\Trait\OptionalPositionRequestTrait;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Length;

class UpdateAirportActionRequest
{
    use OptionalPositionRequestTrait;

    public UuidInterface $id;

    #[Length(4)]
    public ?string $icao = null;

    #[Length(3)]
    public ?string $iata = null;

    #[Length(min: 1, max: 150)]
    public ?string $title = null;

    #[Length(min: 1, max: 150)]
    public ?string $cityTitle = null;

    #[Length(min: 1, max: 150)]
    public ?string $timezone = null;

    public ?bool $isActive = null;

    public function setId(string $id): self
    {
        $this->id = Uuid::fromString($id);
        return $this;
    }
}
