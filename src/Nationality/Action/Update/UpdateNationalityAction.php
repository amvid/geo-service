<?php

declare(strict_types=1);

namespace App\Nationality\Action\Update;

use App\Nationality\Repository\NationalityRepositoryInterface;
use App\Nationality\Exception\NationalityNotFoundException;
use Ramsey\Uuid\UuidInterface;

readonly class UpdateNationalityAction implements UpdateNationalityActionInterface
{
    public function __construct(private NationalityRepositoryInterface $nationalityRepository)
    {
    }

    /**
     * @throws NationalityNotFoundException
     */
    public function run(UpdateNationalityActionRequest $request, UuidInterface $id): UpdateNationalityActionResponse
    {
        $nationality = $this->nationalityRepository->findById($id);

        if (!$nationality) {
            throw new NationalityNotFoundException($id->toString());
        }

        $nationality->setTitle($request->title);
        $this->nationalityRepository->save($nationality, true);

        return new UpdateNationalityActionResponse($nationality);
    }
}
