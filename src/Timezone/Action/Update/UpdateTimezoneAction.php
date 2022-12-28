<?php

declare(strict_types=1);

namespace App\Timezone\Action\Update;

use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;

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
            throw new TimezoneNotFoundException($request->id->toString());
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