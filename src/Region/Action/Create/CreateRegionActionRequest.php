<?php

declare(strict_types=1);

namespace App\Region\Action\Create;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateRegionActionRequest
{
    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }
}
