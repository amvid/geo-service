<?php

declare(strict_types=1);

namespace App\Application\Exception;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserIsNotActiveException extends ApplicationException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('User is not active', Response::HTTP_UNAUTHORIZED, $previous);
    }
}
