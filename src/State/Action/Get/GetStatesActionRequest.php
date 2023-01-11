<?php

declare(strict_types=1);

namespace App\State\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use App\Application\Controller\Request\LimitOffsetRequestTrait;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Length;

class GetStatesActionRequest implements LimitOffsetInterface
{
    use LimitOffsetRequestTrait;

    public ?UuidInterface $id = null;

    #[Length(min: 1, max: 150)]
    public ?string $title = null;

    #[Length(min: 1, max: 5)]
    public ?string $code = null;

    #[Length(min: 1, max: 50)]
    public ?string $type = null;

    #[Length(2)]
    public ?string $countryIso2 = null;

    public static function fromArray(array $params): self
    {
        /** @var GetStatesActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());

        if (isset($params['id'])) {
            $req->id = Uuid::fromString($params['id']);
        }

        $req->code = $params['code'] ?? null;
        $req->countryIso2 = $params['countryIso2'] ?? null;
        $req->type = $params['type'] ?? null;
        $req->title = $params['title'] ?? null;

        return $req;
    }
}
