<?php

declare(strict_types=1);

namespace App\State\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class StateAlreadyExistsException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct("State already exists.", Response::HTTP_CONFLICT);
    }
}
