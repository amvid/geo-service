<?php

declare(strict_types=1);

namespace App\Nationality\Action\Update;

use App\Nationality\Controller\Response\NationalityResponse;
use App\Nationality\Entity\Nationality;

class UpdateNationalityActionResponse
{
    public NationalityResponse $nationalityResponse;

    public function __construct(Nationality $nationality)
    {
        $this->nationalityResponse = new NationalityResponse($nationality);
    }
}
