<?php

declare(strict_types=1);

namespace App\Timezone\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class TimezoneNotFoundException extends ApplicationException
{
    public function __construct(string $identifier)
    {
        parent::__construct("Timezone '$identifier' not found.", Response::HTTP_NOT_FOUND);
    }
}