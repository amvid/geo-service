<?php

declare(strict_types=1);

namespace App\Timezone\Action\Get;

use App\Timezone\Repository\TimezoneRepositoryInterface;

readonly class GetTimezonesAction implements GetTimezonesActionInterface
{
    public function __construct(private TimezoneRepositoryInterface $timezoneRepository)
    {
    }

    public function run(GetTimezonesActionRequest $request): GetTimezonesActionResponse
    {
        return new GetTimezonesActionResponse(
            $this->timezoneRepository->list(
                $request->offset,
                $request->limit,
                $request->title,
                $request->code,
                $request->utc,
            )
        );
    }
}
