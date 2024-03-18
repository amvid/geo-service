<?php

declare(strict_types=1);

namespace App\Nationality\Action\Create;

use App\Nationality\Exception\NationalityAlreadyExistsException;
use App\Nationality\Factory\NationalityFactoryInterface;
use App\Nationality\Repository\NationalityRepositoryInterface;

readonly class CreateNationalityAction implements CreateNationalityActionInterface
{
    public function __construct(
        private NationalityRepositoryInterface $nationalityRepository,
        private NationalityFactoryInterface $nationalityFactory,
    ) {
    }

    /**
     * @throws NationalityAlreadyExistsException
     */
    public function run(CreateNationalityActionRequest $request): CreateNationalityActionResponse
    {
        $exists = $this->nationalityRepository->findByTitle($request->title);

        if ($exists) {
            throw new NationalityAlreadyExistsException();
        }

        $nationality = $this->nationalityFactory
            ->setTitle($request->title)
            ->create();

        $this->nationalityRepository->save($nationality, true);

        return new CreateNationalityActionResponse($nationality);
    }
}
