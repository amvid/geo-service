<?php

declare(strict_types=1);

namespace App\Action\Currency\Update;

use App\Controller\Response\CurrencyResponse;
use App\Entity\Currency;

class UpdateCurrencyActionResponse
{
    public CurrencyResponse $currencyResponse;

    public function __construct(Currency $currency)
    {
        $this->currencyResponse = new CurrencyResponse($currency);
    }
}