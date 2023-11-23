<?php

declare(strict_types=1);

namespace App\Country\Action\GetPhoneCodes;

use App\Country\Repository\CountryRepositoryInterface;
use App\Currency\Exception\CurrencyNotFoundException;
use App\SubRegion\Exception\SubRegionNotFoundException;

readonly class GetPhoneCodesAction implements GetPhoneCodesActionInterface
{
    public function __construct(private CountryRepositoryInterface $countryRepository)
    {
    }

    /**
     * @throws CurrencyNotFoundException
     * @throws SubRegionNotFoundException
     */
    public function run(GetPhoneCodesActionRequest $request): GetPhoneCodesActionResponse
    {
        return new GetPhoneCodesActionResponse(
            $this->countryRepository->findPhoneCodes(
                $request->offset,
                $request->limit,
                $request->title,
                $request->iso2,
                $request->iso3,
                $request->phoneCode,
            )
        );
    }
}
