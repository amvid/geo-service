<?php

declare(strict_types=1);

namespace App\Region\Action\Update;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateRegionActionRequest
{
    public UuidInterface $id;

    #[NotBlank]
    public string $title;

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
