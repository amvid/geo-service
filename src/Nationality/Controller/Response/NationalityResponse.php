<?php

declare(strict_types=1);

namespace App\Nationality\Controller\Response;

use App\Nationality\Entity\Nationality;
use Ramsey\Uuid\UuidInterface;
use OpenApi\Attributes as OA;

class NationalityResponse
{
    #[OA\Property(type: 'string', format: 'uuid')]
    public UuidInterface $id;
    public string $title;

    public function __construct(Nationality $nationality)
    {
        $this->id = $nationality->getId();
        $this->title = $nationality->getTitle();
    }
}
