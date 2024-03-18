<?php

declare(strict_types=1);

namespace App\Nationality\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class NationalityNotFoundException extends ApplicationException
{
    public function __construct(string $identifier)
    {
        parent::__construct("Nationality '$identifier' not found.", Response::HTTP_NOT_FOUND);
    }
}
