<?php

declare(strict_types=1);

namespace App\Currency\Action\Get;

use App\Currency\Controller\Response\CurrencyResponse;
use App\Currency\Entity\Currency;

class GetCurrenciesActionResponse
{
    public array $response = [];

    /**
     * @param array<Currency> $currencies
     */
    public function __construct(array $currencies)
    {
        foreach ($currencies as $currency) {
            $this->response[] = new CurrencyResponse($currency);
        }
    }
}