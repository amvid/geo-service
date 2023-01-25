<?php

declare(strict_types=1);

namespace App\City\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class CityAlreadyExistsException extends ApplicationException
{
    public function __construct(string $identifier)
    {
        parent::__construct("City '$identifier' already exists.", Response::HTTP_CONFLICT);
    }
}
