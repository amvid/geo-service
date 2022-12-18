<?php

declare(strict_types=1);

namespace App\Action\Region\Delete;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeleteRegionActionRequest
{
    #[NotBlank]
    public Uuid $id;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromRfc4122($id);
    }

}
