<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Create;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateSubRegionActionRequest
{
    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $title;

    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $regionTitle;
}
