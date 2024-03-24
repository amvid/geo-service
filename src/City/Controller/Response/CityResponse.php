<?php

declare(strict_types=1);

namespace App\City\Controller\Response;

use App\City\Entity\City;
use App\Country\Controller\Response\CountryResponse;
use App\State\Controller\Response\StateResponse;
use Ramsey\Uuid\UuidInterface;
use OpenApi\Attributes as OA;

class CityResponse
{
    #[OA\Property(type: 'string', format: 'uuid')]
    public UuidInterface $id;
    public string $title;
    public float $longitude;
    public float $latitude;
    public ?int $altitude = null;
    public ?StateResponse $state = null;
    public CountryResponse $country;

    public function __construct(City $city, bool $withRelations = true)
    {
        $this->id = $city->getId();
        $this->title = $city->getTitle();
        $this->longitude = $city->getLongitude();
        $this->latitude = $city->getLatitude();
        $this->altitude = $city->getAltitude();

        if ($withRelations) {
            if ($city->getState()) {
                $this->state = new StateResponse($city->getState(), false);
            }

            $this->country = new CountryResponse($city->getCountry());
        }
    }
}
