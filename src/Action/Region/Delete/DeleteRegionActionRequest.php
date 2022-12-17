<?php

declare(strict_types=1);

namespace App\Action\Region\Delete;

use Symfony\Component\Validator\Constraints\NotBlank;

class DeleteRegionActionRequest
{
    #[NotBlank]
    public string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

}
