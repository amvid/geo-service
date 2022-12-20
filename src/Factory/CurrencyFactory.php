<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Currency;

class CurrencyFactory implements CurrencyFactoryInterface
{
    private Currency $currency;

    public function __construct()
    {
        $this->currency = new Currency();
    }

    public function setCurrency(Currency $currency): CurrencyFactoryInterface
    {
        $this->currency = $currency;
        return $this;
    }

    public function setName(string $name): CurrencyFactoryInterface
    {
        $this->currency->setName($name);
        return $this;
    }

    public function setSymbol(string $symbol): CurrencyFactoryInterface
    {
        $this->currency->setSymbol($symbol);
        return $this;
    }

    public function setCode(string $code): CurrencyFactoryInterface
    {
        $this->currency->setCode($code);
        return $this;
    }

    public function create(): Currency
    {
        return $this->currency;
    }

}