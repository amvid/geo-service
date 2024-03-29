<?php

declare(strict_types=1);

namespace App\Nationality\Action\Create;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateNationalityActionRequest
{
    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $title;
}
