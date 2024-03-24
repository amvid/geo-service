<?php

declare(strict_types=1);

namespace App\Airport\Controller\Response;

use App\Airport\Entity\Airport;
use App\City\Controller\Response\CityResponse;
use App\Timezone\Controller\Response\TimezoneResponse;
use Ramsey\Uuid\UuidInterface;
use OpenApi\Attributes as OA;

class AirportResponse
{
    #[OA\Property(type: 'string', format: 'uuid')]
    public UuidInterface $id;
    public string $title;
    public string $iata;
    public string $icao;
    public bool $isActive;
    public float $longitude;
    public float $latitude;
    public ?int $altitude = null;
    public TimezoneResponse $timezone;
    public CityResponse $city;

    public function __construct(Airport $airport, bool $withRelations = true)
    {
        $this->id = $airport->getId();
        $this->title = $airport->getTitle();
        $this->iata = $airport->getIata();
        $this->icao = $airport->getIcao();
        $this->isActive = $airport->isActive();
        $this->longitude = $airport->getLongitude();
        $this->altitude = $airport->getAltitude();
        $this->latitude = $airport->getLatitude();

        if ($withRelations) {
            $this->timezone = new TimezoneResponse($airport->getTimezone());
            $this->city = new CityResponse($airport->getCity());
        }
    }
}
