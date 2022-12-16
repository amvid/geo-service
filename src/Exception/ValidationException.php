<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class ValidationException extends ApplicationException
{
    public function __construct(string $message)
    {
        parent::__construct(message: $message, code: Response::HTTP_BAD_REQUEST);
    }
}