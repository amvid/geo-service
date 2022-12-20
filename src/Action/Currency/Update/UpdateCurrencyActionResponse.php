<?php

declare(strict_types=1);

namespace App\Action\Currency\Update;

use App\Entity\Currency;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class UpdateCurrencyActionResponse
{
    public UuidInterface $id;
    public string $name;
    public string $code;
    public string $symbol;
    public DateTimeInterface $createdAt;
    public DateTimeInterface $updatedAt;

    public function __construct(Currency $currency)
    {
        $this->id = $currency->getId();
        $this->name = $currency->getName();
        $this->code = $currency->getCode();
        $this->symbol = $currency->getSymbol();
        $this->createdAt = $currency->getCreatedAt();
        $this->updatedAt = $currency->getUpdatedAt();
    }
}