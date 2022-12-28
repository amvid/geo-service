<?php

declare(strict_types=1);

namespace App\Timezone\Action\Update;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UpdateTimezoneActionRequest
{
    public UuidInterface $id;

    public ?string $title = null;

    public ?string $code = null;

    public ?string $utc = null;

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function setUtc(string $utc): self
    {
        $this->utc = $utc;
        return $this;
    }

    public function setId(string $id): self
    {
        $this->id = Uuid::fromString($id);
        return $this;
    }
}