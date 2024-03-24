<?php

declare(strict_types=1);

namespace App\Region\Action\Update;

use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateRegionActionRequest
{
    #[NotBlank]
    public string $title;

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
}
