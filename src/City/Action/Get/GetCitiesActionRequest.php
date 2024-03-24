<?php

declare(strict_types=1);

namespace App\City\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use App\Application\Controller\Request\LimitOffsetRequestTrait;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Length;

class GetCitiesActionRequest implements LimitOffsetInterface
{
    use LimitOffsetRequestTrait;

    public ?UuidInterface $id = null;

    #[Length(min: 1, max: 150)]
    public ?string $title = null;

    #[Length(3)]
    public ?string $iata = null;

    #[Length(2)]
    public ?string $countryIso2 = null;

    #[Length(max: 150)]
    public ?string $stateTitle = null;

    public static function fromArray(array $params): self
    {
        /** @var GetCitiesActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());

        if (isset($params['id'])) {
            $req->id = Uuid::fromString($params['id']);
        }

        $req->title = $params['title'] ?? null;
        $req->iata = $params['iata'] ?? null;
        $req->countryIso2 = $params['countryIso2'] ?? null;
        $req->stateTitle = $params['stateTitle'] ?? null;

        return $req;
    }
}
