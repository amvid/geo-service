<?php

declare(strict_types=1);

namespace App\Action\Region\Update;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateRegionActionRequest
{
    public Uuid $id;

    #[NotBlank]
    public string $title;

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setId(string $id): self
    {
        $this->id = Uuid::fromRfc4122($id);
        return $this;
    }
}