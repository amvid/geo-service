<?php

declare(strict_types=1);

namespace App\State\Action\Get;

use App\Country\Repository\CountryRepositoryInterface;
use App\State\Repository\StateRepositoryInterface;

readonly class GetStatesAction implements GetStatesActionInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
        private StateRepositoryInterface $stateRepository,
    ) {
    }

    public function run(GetStatesActionRequest $request): GetStatesActionResponse
    {
        $countryId = null;
        if ($request->countryIso2) {
            $country = $this->countryRepository->findByIso2($request->countryIso2);

            if (!$country) {
                return new GetStatesActionResponse([]);
            }

            $countryId = $country->getId();
        }

        return new GetStatesActionResponse($this->stateRepository->list(
            $request->offset,
            $request->limit,
            $request->id,
            $request->code,
            $request->title,
            $request->type,
            $countryId,
        ));
    }
}
