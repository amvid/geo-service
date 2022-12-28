<?php

declare(strict_types=1);

namespace App\Currency\Exception;

use App\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class CurrencyAlreadyExistsException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct('Currency already exists.', code: Response::HTTP_CONFLICT);
    }
}