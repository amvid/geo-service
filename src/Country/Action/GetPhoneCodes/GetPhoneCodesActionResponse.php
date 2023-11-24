<?php

declare(strict_types=1);

namespace App\Country\Action\GetPhoneCodes;

use App\Country\Controller\Response\PhoneCodeResponse;
use App\Country\Entity\Country;

class GetPhoneCodesActionResponse
{
    /** @var array<PhoneCodeResponse> $response */
    public array $response = [];

    /**
     * @param array<Country> $phoneCodes
     */
    public function __construct(array $phoneCodes)
    {
        foreach ($phoneCodes as $phoneCode) {
            $this->response[] = new PhoneCodeResponse($phoneCode);
        }
    }
}
