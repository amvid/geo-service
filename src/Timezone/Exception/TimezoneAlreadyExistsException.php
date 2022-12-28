<?php

declare(strict_types=1);

namespace App\Timezone\Exception;

use App\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class TimezoneAlreadyExistsException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(message: 'Timezone already exists.', code: Response::HTTP_CONFLICT);
    }
}