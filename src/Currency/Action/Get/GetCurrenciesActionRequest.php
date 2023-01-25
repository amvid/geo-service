<?php

declare(strict_types=1);

namespace App\Currency\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use App\Application\Controller\Request\LimitOffsetRequestTrait;

class GetCurrenciesActionRequest implements LimitOffsetInterface
{
    use LimitOffsetRequestTrait;

    public ?string $name = null;

    public ?string $code = null;

    public ?string $symbol = null;

    public static function fromArray(array $params): self
    {
        /** @var GetCurrenciesActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());
        $req->name = $params['name'] ?? null;
        $req->code = $params['code'] ?? null;
        $req->symbol = $params['symbol'] ?? null;

        return $req;
    }
}
