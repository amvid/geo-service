<?php

declare(strict_types=1);

namespace App\Action\Currency\Get;

use App\Repository\CurrencyRepositoryInterface;

readonly class GetCurrenciesAction implements GetCurrenciesActionInterface
{
    public function __construct(private CurrencyRepositoryInterface $currencyRepository)
    {
    }

    public function run(GetCurrenciesActionRequest $request): GetCurrenciesActionResponse
    {
        return new GetCurrenciesActionResponse(
            $this->currencyRepository->list(
                $request->offset,
                $request->limit,
                $request->name,
                $request->code,
                $request->symbol,
            )
        );
    }

}