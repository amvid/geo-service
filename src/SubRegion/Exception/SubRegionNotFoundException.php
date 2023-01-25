<?php

declare(strict_types=1);

namespace App\SubRegion\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class SubRegionNotFoundException extends ApplicationException
{
    public function __construct(string $identifier)
    {
        parent::__construct("Sub region '$identifier' not found.", Response::HTTP_NOT_FOUND);
    }
}
