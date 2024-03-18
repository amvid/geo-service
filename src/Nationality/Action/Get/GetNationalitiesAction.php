<?php

declare(strict_types=1);

namespace App\Nationality\Action\Get;

use App\Nationality\Repository\NationalityRepositoryInterface;

readonly class GetNationalitiesAction implements GetNationalitiesActionInterface
{
    public function __construct(private NationalityRepositoryInterface $nationalityRepository)
    {
    }

    public function run(GetNationalitiesActionRequest $request): GetNationalitiesActionResponse
    {
        return new GetNationalitiesActionResponse(
            $this->nationalityRepository->list($request->offset, $request->limit, $request->title)
        );
    }
}
