<?php

declare(strict_types=1);

namespace App\Airport\Exception;

use App\Application\Exception\ApplicationException;

class AirportAlreadyExistsException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct('Airport already exists.');
    }
}