<?php

declare(strict_types=1);

namespace App\SubRegion\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class SubRegionAlreadyExistsException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(message: 'Sub region already exists.', code: Response::HTTP_CONFLICT);
    }
}