<?php

declare(strict_types=1);

namespace App\State\Action\Update;

use App\State\Entity\State;
use App\State\Factory\StateFactoryInterface;
use App\State\Repository\StateRepositoryInterface;

readonly class UpdateStateAction implements UpdateStateActionInterface
{
    public function __construct(
        private StateRepositoryInterface $stateRepository,
        private StateFactoryInterface    $stateFactory,
    )
    {
    }

    public function run(UpdateStateActionRequest $request): UpdateStateActionResponse
    {
        return new UpdateStateActionResponse(new State());
    }
}