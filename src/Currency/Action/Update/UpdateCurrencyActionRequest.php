<?php

declare(strict_types=1);

namespace App\Currency\Action\Update;

class UpdateCurrencyActionRequest
{
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
}
