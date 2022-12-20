<?php

declare(strict_types=1);

namespace App\Action\Currency\Get;

use App\Entity\Currency;

class GetCurrenciesActionResponse
{
    public array $currencies;

    /**
     * @param array<Currency> $currencies
     */
    public function __construct(array $currencies)
    {
        $this->currencies = $currencies;
    }
}