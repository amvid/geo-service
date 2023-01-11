<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use App\Application\Controller\Request\LimitOffsetRequestTrait;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class GetSubRegionsActionRequest implements LimitOffsetInterface
{
    use LimitOffsetRequestTrait;

    public ?string $title = null;

    public ?UuidInterface $regionId = null;

    public static function fromArray(array $params): self
    {
        /** @var GetSubRegionsActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());

        $req->title = $params['title'] ?? null;

        if (isset($params['regionId'])) {
            $req->regionId = Uuid::fromString($params['regionId']);
        }

        return $req;
    }
}