<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class RegionAlreadyExistsException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(message: 'Region already exists.', code: Response::HTTP_CONFLICT);
    }
}