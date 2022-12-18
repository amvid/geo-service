<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class RegionNotFoundException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct('Region not found.', Response::HTTP_NOT_FOUND);
    }
}