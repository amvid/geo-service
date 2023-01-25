<?php

declare(strict_types=1);

namespace App\State\Action\Delete;

use App\State\Repository\StateRepositoryInterface;

readonly class DeleteStateAction implements DeleteStateActionInterface
{
    public function __construct(private StateRepositoryInterface $stateRepository)
    {
    }

    public function run(DeleteStateActionRequest $request): DeleteStateActionResponse
    {
        $state = $this->stateRepository->findById($request->id);
        $res = new DeleteStateActionResponse();

        if (!$state) {
            return $res;
        }

        $this->stateRepository->remove($state, true);
        return $res;
    }
}
