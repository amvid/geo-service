<?php

declare(strict_types=1);

namespace App\Timezone\Action\Create;

use App\Timezone\Exception\TimezoneAlreadyExistsException;
use App\Timezone\Factory\TimezoneFactoryInterface;
use App\Timezone\Repository\TimezoneRepositoryInterface;

readonly class CreateTimezoneAction implements CreateTimezoneActionInterface
{
    public function __construct(
        private TimezoneRepositoryInterface $timezoneRepository,
        private TimezoneFactoryInterface $timezoneFactory,
    ) {
    }

    /**
     * @throws TimezoneAlreadyExistsException
     */
    public function run(CreateTimezoneActionRequest $request): CreateTimezoneActionResponse
    {
        $exists = $this->timezoneRepository->findByTitle($request->title);

        if ($exists) {
            throw new TimezoneAlreadyExistsException();
        }

        $timezone = $this->timezoneFactory
            ->setTitle($request->title)
            ->setCode($request->code)
            ->setUtc($request->utc)
            ->create();

        $this->timezoneRepository->save($timezone, true);

        return new CreateTimezoneActionResponse($timezone);
    }
}
