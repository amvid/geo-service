<?php

declare(strict_types=1);

namespace App\Country\Action\GetPhoneCodes;

interface GetPhoneCodesActionInterface
{
    public function run(GetPhoneCodesActionRequest $request): GetPhoneCodesActionResponse;
}
