<?php

declare(strict_types=1);

namespace App\Region\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use App\Application\Controller\Request\LimitOffsetRequestTrait;

class GetRegionsActionRequest implements LimitOffsetInterface
{
    use LimitOffsetRequestTrait;

    public ?string $title = null;

    public static function fromArray(array $params): self
    {
        /** @var GetRegionsActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());

        $req->title = $params['title'] ?? null;

        return $req;
    }
}
