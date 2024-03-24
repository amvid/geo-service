<?php

declare(strict_types=1);

namespace App\Nationality\Action\Update;

use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateNationalityActionRequest
{
    #[NotBlank]
    public string $title;

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
}
