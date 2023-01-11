<?php

declare(strict_types=1);

namespace App\Country\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use App\Application\Controller\Request\LimitOffsetRequestTrait;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class GetCountriesActionRequest implements LimitOffsetInterface
{
    use LimitOffsetRequestTrait;

    public ?UuidInterface $id = null;
    public ?string $iso2 = null;
    public ?string $iso3 = null;
    public ?string $title = null;
    public ?string $nativeTitle = null;
    public ?string $phoneCode = null;
    public ?string $numericCode = null;
    public ?string $tld = null;
    public ?string $subRegion = null;
    public ?string $currencyCode = null;

    public static function fromArray(array $params): self
    {
        /** @var GetCountriesActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());

        if (isset($params['id'])) {
            $req->id = Uuid::fromString($params['id']);
        }

        $req->iso2 = $params['iso2'] ?? null;
        $req->iso3 = $params['iso3'] ?? null;
        $req->phoneCode = $params['phoneCode'] ?? null;
        $req->numericCode = $params['numericCode'] ?? null;
        $req->title = $params['title'] ?? null;
        $req->nativeTitle = $params['nativeTitle'] ?? null;
        $req->tld = $params['tld'] ?? null;
        $req->subRegion = $params['subRegion'] ?? null;
        $req->currencyCode = $params['currencyCode'] ?? null;

        return $req;
    }
}