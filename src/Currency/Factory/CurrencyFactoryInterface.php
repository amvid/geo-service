<?php

declare(strict_types=1);

namespace App\Currency\Factory;

use App\Currency\Entity\Currency;

interface CurrencyFactoryInterface
{
    public function setCurrency(Currency $currency): self;

    public function setName(string $name): self;

    public function setSymbol(string $symbol): self;

    public function setCode(string $code): self;

    public function create(): Currency;
}