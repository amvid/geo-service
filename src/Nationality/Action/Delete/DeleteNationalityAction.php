<?php

declare(strict_types=1);

namespace App\Nationality\Action\Delete;

use App\Nationality\Repository\NationalityRepositoryInterface;

readonly class DeleteNationalityAction implements DeleteNationalityActionInterface
{
    public function __construct(private NationalityRepositoryInterface $nationalityRepository)
    {
    }

    public function run(DeleteNationalityActionRequest $request): DeleteNationalityActionResponse
    {
        $exists = $this->nationalityRepository->findById($request->id);
        $res = new DeleteNationalityActionResponse();

        if (!$exists) {
            return $res;
        }

        $this->nationalityRepository->remove($exists, true);

        return $res;
    }
}
