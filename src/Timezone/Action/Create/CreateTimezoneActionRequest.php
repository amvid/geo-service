<?php

declare(strict_types=1);

namespace App\Timezone\Action\Create;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateTimezoneActionRequest
{
    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $title;

    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $code;

    #[NotBlank]
    #[Length(min: 1, max: 50)]
    public string $utc;
}
