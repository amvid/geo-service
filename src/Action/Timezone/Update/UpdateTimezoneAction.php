<?php

declare(strict_types=1);

namespace App\Action\Timezone\Update;

use App\Exception\TimezoneNotFoundException;
use App\Repository\TimezoneRepositoryInterface;

readonly class UpdateTimezoneAction implements UpdateTimezoneActionInterface
{
    public function __construct(private TimezoneRepositoryInterface $timezoneRepository)
    {
    }

    /**
     * @throws TimezoneNotFoundException
     */
    public function run(UpdateTimezoneActionRequest $request): UpdateTimezoneActionResponse
    {
        $timezone = $this->timezoneRepository->findById($request->id);

        if (!$timezone) {
            throw new TimezoneNotFoundException();
        }

        if ($request->title) {
            $timezone->setTitle($request->title);
        }

        if ($request->code) {
            $timezone->setCode($request->code);
        }

        if ($request->utc) {
            $timezone->setUtc($request->utc);
        }

        $this->timezoneRepository->save($timezone, true);

        return new UpdateTimezoneActionResponse($timezone);
    }

}