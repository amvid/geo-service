<?php

declare(strict_types=1);

namespace App\Nationality\Action\Update;

use App\Nationality\Repository\NationalityRepositoryInterface;
use App\Nationality\Exception\NationalityNotFoundException;

readonly class UpdateNationalityAction implements UpdateNationalityActionInterface
{
    public function __construct(private NationalityRepositoryInterface $nationalityRepository)
    {
    }

    /**
     * @throws NationalityNotFoundException
     */
    public function run(UpdateNationalityActionRequest $request): UpdateNationalityActionResponse
    {
        $nationality = $this->nationalityRepository->findById($request->id);

        if (!$nationality) {
            throw new NationalityNotFoundException($request->id->toString());
        }

        $nationality->setTitle($request->title);
        $this->nationalityRepository->save($nationality, true);

        return new UpdateNationalityActionResponse($nationality);
    }
}
