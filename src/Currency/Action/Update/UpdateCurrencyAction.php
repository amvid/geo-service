<?php

declare(strict_types=1);

namespace App\Currency\Action\Update;

use App\Currency\Exception\CurrencyNotFoundException;
use App\Currency\Repository\CurrencyRepositoryInterface;

readonly class UpdateCurrencyAction implements UpdateCurrencyActionInterface
{
    public function __construct(private CurrencyRepositoryInterface $currencyRepository)
    {
    }

    /**
     * @throws CurrencyNotFoundException
     */
    public function run(UpdateCurrencyActionRequest $request): UpdateCurrencyActionResponse
    {
        $currency = $this->currencyRepository->findById($request->id);

        if (!$currency) {
            throw new CurrencyNotFoundException($request->id->toString());
        }

        if ($request->name) {
            $currency->setName($request->name);
        }

        if ($request->code) {
            $currency->setCode($request->code);
        }

        if ($request->symbol) {
            $currency->setSymbol($request->symbol);
        }

        $this->currencyRepository->save($currency, true);

        return new UpdateCurrencyActionResponse($currency);
    }
}
