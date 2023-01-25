<?php

declare(strict_types=1);

namespace App\Timezone\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use App\Application\Controller\Request\LimitOffsetRequestTrait;

class GetTimezonesActionRequest implements LimitOffsetInterface
{
    use LimitOffsetRequestTrait;

    public ?string $title = null;

    public ?string $code = null;

    public ?string $utc = null;

    public static function fromArray(array $params): self
    {
        /** @var GetTimezonesActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());
        $req->title = $params['title'] ?? null;
        $req->code = $params['code'] ?? null;
        $req->utc = $params['utc'] ?? null;

        return $req;
    }
}
