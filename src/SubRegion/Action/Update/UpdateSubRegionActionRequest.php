<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Update;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateSubRegionActionRequest
{
    public UuidInterface $id;

    #[NotBlank]
    public string $title;

    public ?UuidInterface $regionId = null;

    public function __construct(string $title, ?string $regionId = null)
    {
        $this->title = $title;

        if ($regionId) {
            $this->regionId = Uuid::fromString($regionId);
        }
    }

    public function setRegionId(string $regionId): self
    {
        $this->regionId = Uuid::fromString($regionId);
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setId(string $id): self
    {
        $this->id = Uuid::fromString($id);
        return $this;
    }
}