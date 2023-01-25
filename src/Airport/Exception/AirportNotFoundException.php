<?php

declare(strict_types=1);

namespace App\Airport\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class AirportNotFoundException extends ApplicationException
{
    public function __construct(string $identifier)
    {
        parent::__construct("Airport '$identifier' not found.", Response::HTTP_NOT_FOUND);
    }
}
