<?php

declare(strict_types=1);

namespace App\Application\Trait;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

#[HasLifecycleCallbacks]
trait TimestampTrait
{
    #[Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    #[Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    #[PrePersist]
    public function setCreatedAt(): void
    {
        $now = new DateTimeImmutable();
        $this->updatedAt = $now;
        $this->createdAt = $now;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
