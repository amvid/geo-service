<?php

declare(strict_types=1);

namespace App\Country\Action\Delete;

use App\Country\Repository\CountryRepositoryInterface;

readonly class DeleteCountryAction implements DeleteCountryActionInterface
{
    public function __construct(private CountryRepositoryInterface $countryRepository)
    {
    }

    public function run(DeleteCountryActionRequest $request): DeleteCountryActionResponse
    {
        $country = $this->countryRepository->findById($request->id);
        $res = new DeleteCountryActionResponse();

        if (!$country) {
            return $res;
        }

        $this->countryRepository->remove($country, true);
        return $res;
    }
}
