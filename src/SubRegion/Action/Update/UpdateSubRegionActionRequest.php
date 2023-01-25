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

    public ?string $regionTitle = null;

    public function setId(string $id): self
    {
        $this->id = Uuid::fromString($id);
        return $this;
    }
}
