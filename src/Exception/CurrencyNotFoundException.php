<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class CurrencyNotFoundException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct('Currency not found.', Response::HTTP_NOT_FOUND);
    }
}