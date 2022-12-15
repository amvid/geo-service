<?php

declare(strict_types=1);

namespace App\Trait;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

#[HasLifecycleCallbacks]
trait TimestampTrait
{
    #[Column(type: 'datetime')]
    private DateTimeInterface $updatedAt;

    #[Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }

    #[PrePersist]
    public function setCreatedAt(): void
    {
        $now = new DateTime();
        $this->updatedAt = $now;
        $this->createdAt = $now;
    }
}