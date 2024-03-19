<?php

declare(strict_types=1);

namespace App\Airport\Action\Query;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use App\Application\Controller\Request\LimitOffsetRequestTrait;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class QueryAirportsActionRequest implements LimitOffsetInterface
{
    use LimitOffsetRequestTrait;

    #[NotBlank]
    #[Length(min: 2)]
    public string $query;

    public static function fromArray(array $params): self
    {
        /** @var QueryAirportsActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());
        $req->query = $params['query'] ?? null;

        return $req;
    }
}
