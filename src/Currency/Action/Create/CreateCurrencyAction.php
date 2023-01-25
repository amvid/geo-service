<?php

declare(strict_types=1);

namespace App\Currency\Action\Create;

use App\Currency\Exception\CurrencyAlreadyExistsException;
use App\Currency\Factory\CurrencyFactoryInterface;
use App\Currency\Repository\CurrencyRepositoryInterface;

readonly class CreateCurrencyAction implements CreateCurrencyActionInterface
{
    public function __construct(
        private CurrencyRepositoryInterface $currencyRepository,
        private CurrencyFactoryInterface $currencyFactory,
    ) {
    }

    /**
     * @throws CurrencyAlreadyExistsException
     */
    public function run(CreateCurrencyActionRequest $request): CreateCurrencyActionResponse
    {
        $exists = $this->currencyRepository->findByCode($request->code);

        if ($exists) {
            throw new CurrencyAlreadyExistsException();
        }

        $region = $this->currencyFactory
            ->setName($request->name)
            ->setCode($request->code)
            ->setSymbol($request->symbol)
            ->create();

        $this->currencyRepository->save($region, true);

        return new CreateCurrencyActionResponse($region);
    }
}
