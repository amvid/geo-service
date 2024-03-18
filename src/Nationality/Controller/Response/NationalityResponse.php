<?php

declare(strict_types=1);

namespace App\Nationality\Controller\Response;

use App\Nationality\Entity\Nationality;
use Ramsey\Uuid\UuidInterface;

class NationalityResponse
{
    public UuidInterface $id;
    public string $title;

    public function __construct(Nationality $nationality)
    {
        $this->id = $nationality->getId();
        $this->title = $nationality->getTitle();
    }
}
