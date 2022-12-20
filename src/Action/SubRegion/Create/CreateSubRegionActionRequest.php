<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Create;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateSubRegionActionRequest
{
    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $title;

    #[NotBlank]
    public UuidInterface $regionId;

    public function __construct(string $title, string $regionId)
    {
        $this->title = $title;
        $this->regionId = Uuid::fromString($regionId);
    }
}
