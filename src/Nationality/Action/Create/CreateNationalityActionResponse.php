<?php

declare(strict_types=1);

namespace App\Nationality\Action\Create;

use App\Nationality\Controller\Response\NationalityResponse;
use App\Nationality\Entity\Nationality;

class CreateNationalityActionResponse
{
    public NationalityResponse $nationalityResponse;

    public function __construct(Nationality $nationality)
    {
        $this->nationalityResponse = new NationalityResponse($nationality);
    }
}
