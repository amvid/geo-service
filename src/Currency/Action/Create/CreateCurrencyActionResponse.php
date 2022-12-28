<?php

declare(strict_types=1);

namespace App\Currency\Action\Create;

use App\Currency\Controller\Response\CurrencyResponse;
use App\Currency\Entity\Currency;

class CreateCurrencyActionResponse
{
    public CurrencyResponse $currencyResponse;

    public function __construct(Currency $currency)
    {
        $this->currencyResponse = new CurrencyResponse($currency);
    }
}