<?php

declare(strict_types=1);

namespace App\Country\Controller\Response;

use App\Country\Entity\Country;

class PhoneCodeResponse
{
    public string $title;
    public string $iso2;
    public string $iso3;
    public string $phoneCode;
    public string $flag;

    public function __construct(Country $country)
    {
        $this->title = $country->getTitle();
        $this->iso2 = $country->getIso2();
        $this->iso3 = $country->getIso3();
        $this->phoneCode = $country->getPhoneCode();
        $this->flag = $country->getFlag();
    }
}
