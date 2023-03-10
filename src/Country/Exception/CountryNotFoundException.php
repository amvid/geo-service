<?php

declare(strict_types=1);

namespace App\Country\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class CountryNotFoundException extends ApplicationException
{
    public function __construct(string $identifier)
    {
        parent::__construct("Country '$identifier' not found.", Response::HTTP_NOT_FOUND);
    }
}
