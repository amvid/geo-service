<?php

declare(strict_types=1);

namespace App\Country\Action\GetPhoneCodes;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use App\Application\Controller\Request\LimitOffsetRequestTrait;

class GetPhoneCodesActionRequest implements LimitOffsetInterface
{
    use LimitOffsetRequestTrait;

    public ?string $iso2 = null;
    public ?string $iso3 = null;
    public ?string $title = null;
    public ?string $phoneCode = null;

    public static function fromArray(array $params): self
    {
        /** @var GetPhoneCodesActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());

        $req->iso2 = $params['iso2'] ?? null;
        $req->iso3 = $params['iso3'] ?? null;
        $req->phoneCode = $params['phoneCode'] ?? null;
        $req->title = $params['title'] ?? null;

        return $req;
    }
}
