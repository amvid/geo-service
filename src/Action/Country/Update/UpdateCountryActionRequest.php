<?php

declare(strict_types=1);

namespace App\Action\Country\Update;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;

class UpdateCountryActionRequest
{
    public ?UuidInterface $id = null;

    #[Length(min: 1, max: 150)]
    public ?string $nativeTitle = null;

    #[Length(min: 1, max: 20)]
    public ?string $phoneCode = null;

    #[Length(min: 1, max: 150)]
    public ?UuidInterface $subRegionId = null;

    #[Length(min: 1, max: 3)]
    public ?UuidInterface $currencyId = null;

    #[Length(min: 1, max: 100)]
    public ?string $flag = null;

    #[Length(min: 1, max: 20)]
    public ?string $tld = null;

    /**
     * @param array<UuidInterface> $timezones
     */
    #[Count(min: 1)]
    public ?array $timezones = null;

    public ?float $latitude = null;

    public ?float $longitude = null;

    public ?int $altitude = null;

    public function __construct(?string $subRegionId = null, ?string $currencyId = null, ?array $timezones = null)
    {
        if ($subRegionId) {
            $this->subRegionId = Uuid::fromString($subRegionId);
        }

        if ($currencyId) {
            $this->currencyId = Uuid::fromString($currencyId);
        }

        if (!empty($timezones)) {
            foreach ($timezones as $tzId) {
                $this->timezones[] = Uuid::fromString($tzId);
            }
        }
    }

    public function setId(string $id): self
    {
        $this->id = Uuid::fromString($id);
        return $this;
    }
}