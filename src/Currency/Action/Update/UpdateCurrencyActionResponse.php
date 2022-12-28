<?php

declare(strict_types=1);

namespace App\Currency\Action\Update;

use App\Currency\Controller\Response\CurrencyResponse;
use App\Currency\Entity\Currency;

class UpdateCurrencyActionResponse
{
    public CurrencyResponse $currencyResponse;

    public function __construct(Currency $currency)
    {
        $this->currencyResponse = new CurrencyResponse($currency);
    }
}