<?php

declare(strict_types=1);

namespace App\Action\Currency\Create;

use App\Entity\Currency;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class CreateCurrencyActionResponse
{
    public UuidInterface $id;
    public string $name;
    public string $code;
    public string $symbol;
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

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