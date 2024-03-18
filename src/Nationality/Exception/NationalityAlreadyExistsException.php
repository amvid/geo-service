<?php

declare(strict_types=1);

namespace App\Nationality\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class NationalityAlreadyExistsException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(message: 'Nationality already exists.', code: Response::HTTP_CONFLICT);
    }
}
