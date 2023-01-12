<?php

declare(strict_types=1);

namespace App\City\Action\Update;

use App\Application\Trait\OptionalPositionRequestTrait;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Length;

class UpdateCityActionRequest
{
    use OptionalPositionRequestTrait;

    public UuidInterface $id;

    #[Length(min: 1, max: 150)]
    public ?string $title = null;

    #[Length(2)]
    public ?string $countryIso2 = null;

    #[Length(max: 150)]
    public ?string $stateTitle = null;

    public function setId(string $id): self
    {
        $this->id = Uuid::fromString($id);
        return $this;
    }
}