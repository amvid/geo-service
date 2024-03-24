<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Update;

use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateSubRegionActionRequest
{
    #[NotBlank]
    public string $title;

    public ?string $regionTitle = null;
}
