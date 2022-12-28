<?php

declare(strict_types=1);

namespace App\Action\Currency\Get;

use App\Controller\Response\CurrencyResponse;
use App\Entity\Currency;

readonly class GetCurrenciesActionResponse
{
    public array $response;

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