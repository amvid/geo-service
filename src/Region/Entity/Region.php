<?php

declare(strict_types=1);

namespace App\Region\Entity;

use App\Application\Trait\TimestampTrait;
use App\Region\Repository\RegionRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('title')]
class Region
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\Column(length: 150, unique: true)]
    private string $title;

    public function __construct(?UuidInterface $id = null)
    {
        if ($id) {
            $this->id = $id;
        }
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
