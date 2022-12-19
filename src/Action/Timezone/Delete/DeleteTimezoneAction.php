<?php

declare(strict_types=1);

namespace App\Action\Timezone\Delete;

use App\Repository\TimezoneRepositoryInterface;

readonly class DeleteTimezoneAction implements DeleteTimezoneActionInterface
{
    public function __construct(private TimezoneRepositoryInterface $timezoneRepository)
    {
    }

    public function run(DeleteTimezoneActionRequest $request): DeleteTimezoneActionResponse
    {
        $exists = $this->timezoneRepository->findById($request->id);
        $res = new DeleteTimezoneActionResponse();

        if (!$exists) {
            return $res;
        }

        $this->timezoneRepository->remove($exists, true);

        return $res;
    }

}