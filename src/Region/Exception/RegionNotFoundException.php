<?php

declare(strict_types=1);

namespace App\Region\Exception;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class RegionNotFoundException extends ApplicationException
{
    public function __construct(string $identifier)
    {
        parent::__construct("Region '$identifier' not found.", Response::HTTP_NOT_FOUND);
    }
}