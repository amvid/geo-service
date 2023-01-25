<?php

declare(strict_types=1);

namespace App\Currency\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class CurrencyNotFoundException extends ApplicationException
{
    public function __construct(string $identifier)
    {
        parent::__construct("Currency '$identifier' not found.", Response::HTTP_NOT_FOUND);
    }
}
