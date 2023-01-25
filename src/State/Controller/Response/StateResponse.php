<?php

declare(strict_types=1);

namespace App\State\Controller\Response;

use App\Country\Controller\Response\CountryResponse;
use App\State\Entity\State;
use Ramsey\Uuid\UuidInterface;

class StateResponse
{
    public UuidInterface $id;
    public string $title;
    public string $code;
    public float $latitude;
    public float $longitude;
    public ?int $altitude;
    public ?string $type;
    public CountryResponse $country;

    public function __construct(State $state, bool $withRelations = true)
    {
        $this->id = $state->getId();
        $this->title = $state->getTitle();
        $this->code = $state->getCode();
        $this->type = $state->getType();
        $this->latitude = $state->getLatitude();
        $this->longitude = $state->getLongitude();
        $this->altitude = $state->getAltitude();

        if ($withRelations) {
            $this->country = new CountryResponse($state->getCountry());
        }
    }
}
