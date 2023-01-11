<?php

declare(strict_types=1);

namespace App\Airport\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use App\Application\Controller\Request\LimitOffsetRequestTrait;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class GetAirportsActionRequest implements LimitOffsetInterface
{
    use LimitOffsetRequestTrait;

    public ?UuidInterface $id = null;
    public ?string $title = null;
    public ?string $iata = null;
    public ?string $icao = null;
    public ?string $cityTitle = null;
    public ?string $timezone = null;

    public static function fromArray(array $params): self
    {
        /** @var GetAirportsActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());

        if (isset($params['id'])) {
            $req->id = Uuid::fromString($params['id']);
        }

        $req->title = $params['title'] ?? null;
        $req->iata = $params['iata'] ?? null;
        $req->icao = $params['icao'] ?? null;
        $req->cityTitle = $params['cityTitle'] ?? null;
        $req->timezone = $params['timezone'] ?? null;

        return $req;
    }
}