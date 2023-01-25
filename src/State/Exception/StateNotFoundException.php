<?php

declare(strict_types=1);

namespace App\State\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class StateNotFoundException extends ApplicationException
{
    public function __construct(string $identifier)
    {
        parent::__construct("State '$identifier' not found.", Response::HTTP_NOT_FOUND);
    }
}
