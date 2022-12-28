<?php

declare(strict_types=1);

namespace App\Currency\Action\Update;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UpdateCurrencyActionRequest
{
    public UuidInterface $id;

    public ?string $name = null;

    public ?string $code = null;

    public ?string $symbol = null;

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;
        return $this;
    }

    public function setId(string $id): self
    {
        $this->id = Uuid::fromString($id);
        return $this;
    }
}