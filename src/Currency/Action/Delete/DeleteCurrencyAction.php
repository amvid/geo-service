<?php

declare(strict_types=1);

namespace App\Currency\Action\Delete;

use App\Currency\Repository\CurrencyRepositoryInterface;

readonly class DeleteCurrencyAction implements DeleteCurrencyActionInterface
{
    public function __construct(private CurrencyRepositoryInterface $currencyRepository)
    {
    }

    public function run(DeleteCurrencyActionRequest $request): DeleteCurrencyActionResponse
    {
        $exists = $this->currencyRepository->findById($request->id);
        $res = new DeleteCurrencyActionResponse();

        if (!$exists) {
            return $res;
        }

        $this->currencyRepository->remove($exists, true);

        return $res;
    }
}
